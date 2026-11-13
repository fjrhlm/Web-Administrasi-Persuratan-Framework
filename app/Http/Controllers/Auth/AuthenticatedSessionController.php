<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * Login accepts NIK (16 digits) or username, then authenticates
     * using the resolved user's email + provided password.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginValue = $request->input('login');
        $password   = $request->input('password');

        // Determine if the login value is an email, a 16-digit NIK, or a username
        if (filter_var($loginValue, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $loginValue)->first();
        } elseif (preg_match('/^\d{16}$/', $loginValue)) {
            $user = User::where('nik', $loginValue)->first();
        } else {
            $user = User::where('username', $loginValue)->first();
        }

        if (!$user || !Hash::check($password, $user->password)) {
            // Catat percobaan login gagal ke audit trail
            ActivityLog::create([
                'user_id'    => $user?->id ?? null,
                'aksi'       => 'login_gagal',
                'keterangan' => "Percobaan login gagal dengan identifier: '{$loginValue}'",
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Catat login berhasil ke audit trail
        ActivityLog::record(
            'login',
            "User '{$user->name}' (role: {$user->role}) berhasil login."
        );

        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('warga.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Catat logout ke audit trail sebelum session dihapus
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            ActivityLog::record('logout', "User '{$user->name}' logout.");
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

