<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    /**
     * Display the activity log dashboard.
     */
    public function index(Request $request): View
    {
        $query = ActivityLog::with('user')->latest();

        // Filter berdasarkan jenis aksi
        if ($request->filled('aksi')) {
            $query->where('aksi', $request->query('aksi'));
        }

        // Filter berdasarkan kata kunci (cari di keterangan atau IP)
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(20)->withQueryString();

        $jenisAksi = [
            'login', 'login_gagal', 'logout', 'pengajuan_baru',
            'ubah_status', 'ubah_password', 'akses_berkas', 'akses_ditolak', 'cetak_surat',
        ];

        return view('admin.activity-log.index', compact('logs', 'jenisAksi'));
    }
}
