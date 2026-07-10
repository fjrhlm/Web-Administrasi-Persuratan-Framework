<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the warga dashboard.
     */
    public function index(): View
    {
        $userId = Auth::id();

        $activePengajuan = PengajuanSurat::where('user_id', $userId)
            ->whereIn('status', ['Menunggu', 'Diproses'])
            ->count();

        $completedSurat = PengajuanSurat::where('user_id', $userId)
            ->where('status', 'Selesai')
            ->count();

        return view('warga.dashboard', compact('activePengajuan', 'completedSurat'));
    }
}
