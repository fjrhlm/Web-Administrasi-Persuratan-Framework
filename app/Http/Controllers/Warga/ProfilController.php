<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class ProfilController extends Controller
{
    /**
     * Display the warga profile.
     */
    public function index(): View
    {
        $user = Auth::user();

        return view('warga.profil', compact('user'));
    }

    /**
     * Update the warga password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        ActivityLog::record('ubah_password', "Warga '{$user->name}' berhasil memperbarui kata sandi.");

        return redirect()
            ->route('warga.profil.index')
            ->with('success', 'Password berhasil diperbarui.');
    }
}
