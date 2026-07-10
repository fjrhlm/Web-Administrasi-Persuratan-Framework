<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    /**
     * Display the current settings.
     */
    public function index(): View
    {
        $pengaturan = Pengaturan::first();

        return view('admin.pengaturan', compact('pengaturan'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kades' => ['required', 'string', 'max:100'],
            'nip_kades' => ['required', 'string', 'max:50'],
            'jabatan' => ['required', 'string', 'max:100'],
        ]);

        $pengaturan = Pengaturan::first();

        if ($pengaturan) {
            $pengaturan->update($validated);
        } else {
            Pengaturan::create($validated);
        }

        return redirect()
            ->route('admin.pengaturan.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
