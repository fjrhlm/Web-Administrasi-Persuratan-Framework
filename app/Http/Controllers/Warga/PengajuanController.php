<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the user's pengajuan surat.
     */
    public function index(): View
    {
        $pengajuans = PengajuanSurat::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('warga.pengajuan.index', compact('pengajuans'));
    }

    /**
     * Show the form for creating a new pengajuan surat.
     */
    public function create(): View
    {
        return view('warga.pengajuan.create');
    }

    /**
     * Store a newly created pengajuan surat.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_surat' => ['required', 'string', 'in:SKTM,SKU,Domisili,Pengantar SKCK,Belum Menikah,Kematian,Kelahiran,Penghasilan Orang Tua,Pindah Penduduk'],
            'keperluan' => ['required', 'string', 'max:1000'],
            'file_ktp' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
            'file_pengantar' => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
            'file_tambahan' => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
            'file_kk' => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:2048'],
        ]);

        // Handle file uploads
        $fileKtp = $request->file('file_ktp')->store('ktp', 'uploads');

        $filePengantar = null;
        if ($request->hasFile('file_pengantar')) {
            $filePengantar = $request->file('file_pengantar')->store('pengantar', 'uploads');
        }

        $fileTambahan = null;
        if ($request->hasFile('file_tambahan')) {
            $fileTambahan = $request->file('file_tambahan')->store('tambahan', 'uploads');
        }

        $fileKk = null;
        if ($request->hasFile('file_kk')) {
            $fileKk = $request->file('file_kk')->store('kk', 'uploads');
        }

        PengajuanSurat::create([
            'user_id' => Auth::id(),
            'jenis_surat' => $validated['jenis_surat'],
            'keperluan' => $validated['keperluan'],
            'file_ktp' => $fileKtp,
            'file_pengantar' => $filePengantar,
            'file_tambahan' => $fileTambahan,
            'file_kk' => $fileKk,
            'tgl_pengajuan' => now()->toDateString(),
            'status' => 'Menunggu',
        ]);

        return redirect()
            ->route('warga.pengajuan.index')
            ->with('success', 'Pengajuan surat berhasil dikirim.');
    }
}
