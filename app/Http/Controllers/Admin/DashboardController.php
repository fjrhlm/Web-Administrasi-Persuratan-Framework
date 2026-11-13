<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $pendingSurat = PengajuanSurat::where('status', 'Menunggu')->count();

        $totalSuratBulanIni = PengajuanSurat::whereMonth('tgl_pengajuan', now()->month)
            ->whereYear('tgl_pengajuan', now()->year)
            ->count();

        $totalWarga = User::where('role', 'warga')->count();

        $recentLogs = ActivityLog::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('pendingSurat', 'totalSuratBulanIni', 'totalWarga', 'recentLogs'));
    }
}

