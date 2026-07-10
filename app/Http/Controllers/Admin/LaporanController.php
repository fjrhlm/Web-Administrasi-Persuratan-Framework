<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    /**
     * Display the monthly report of completed letters.
     */
    public function index(Request $request): View
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $pengajuans = PengajuanSurat::with('user')
            ->where('status', 'Selesai')
            ->whereMonth('tgl_pengajuan', $bulan)
            ->whereYear('tgl_pengajuan', $tahun)
            ->latest()
            ->get();

        return view('admin.laporan.index', compact('pengajuans', 'bulan', 'tahun'));
    }

    /**
     * Display the print view of the monthly report.
     */
    public function cetak(Request $request): View
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $pengajuans = PengajuanSurat::with('user')
            ->where('status', 'Selesai')
            ->whereMonth('tgl_pengajuan', $bulan)
            ->whereYear('tgl_pengajuan', $tahun)
            ->latest()
            ->get();

        $pengaturan = Pengaturan::first();

        return view('admin.laporan.cetak', compact('pengajuans', 'pengaturan', 'bulan', 'tahun'));
    }
}
