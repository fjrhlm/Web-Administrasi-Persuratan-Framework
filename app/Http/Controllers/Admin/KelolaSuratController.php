<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\PengajuanSurat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KelolaSuratController extends Controller
{
    /**
     * Display a listing of all pengajuan surat.
     */
    public function index(Request $request): View
    {
        $query = PengajuanSurat::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $pengajuans = $query->paginate(10)->withQueryString();

        return view('admin.kelola-surat.index', compact('pengajuans'));
    }

    /**
     * Display a single pengajuan surat for verification.
     */
    public function show(int $id): View
    {
        $pengajuan = PengajuanSurat::with('user')->findOrFail($id);

        return view('admin.kelola-surat.show', compact('pengajuan'));
    }

    /**
     * Update the status and admin remarks of a pengajuan surat.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:Menunggu,Diproses,Ditolak,Selesai'],
            'keterangan_admin' => ['nullable', 'string', 'max:1000'],
        ]);

        $pengajuan = PengajuanSurat::findOrFail($id);
        $pengajuan->update($validated);

        return redirect()
            ->route('admin.kelola-surat.show', $id)
            ->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    /**
     * Display the print view of an official letter.
     */
    public function cetakSurat(int $id): View
    {
        $pengajuan = PengajuanSurat::with('user')->findOrFail($id);
        $pengaturan = Pengaturan::first();

        // Letter numbering logic
        $kodeSurat = match ($pengajuan->jenis_surat) {
            'SKTM' => '141',
            'SKU' => '520',
            'Domisili' => '141',
            'Pengantar SKCK' => '332',
            'Belum Menikah' => '474.2',
            'Kematian' => '474.3',
            'Kelahiran' => '474.1',
            'Penghasilan Orang Tua' => '420',
            'Pindah Penduduk' => '475',
            default => '000',
        };

        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
            5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
            9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];

        $bulanRomawi = $romanMonths[$pengajuan->tgl_pengajuan->month];
        $tahun = $pengajuan->tgl_pengajuan->year;
        $nomorUrut = str_pad($pengajuan->id, 3, '0', STR_PAD_LEFT);

        $nomorSurat = "{$kodeSurat} / {$nomorUrut} / PEM / {$bulanRomawi} / {$tahun}";

        return view('admin.cetak-surat', compact('pengajuan', 'pengaturan', 'nomorSurat'));
    }
}
