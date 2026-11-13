<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SecureFileController extends Controller
{
    /**
     * Serve file berkas dokumen secara aman dengan otorisasi ketat.
     * Mencegah IDOR: hanya pemilik berkas dan admin yang dapat mengakses.
     *
     * @param int    $id   ID pengajuan surat
     * @param string $type Jenis berkas: ktp | kk | pengantar | tambahan
     */
    public function serve(Request $request, int $id, string $type): StreamedResponse
    {
        // 1. Ambil pengajuan — 404 jika tidak ditemukan
        $pengajuan = PengajuanSurat::findOrFail($id);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 2. Cek Otorisasi: hanya pemilik atau admin yang boleh akses
        if (!$user->isAdmin() && $pengajuan->user_id !== $user->id) {
            // Catat percobaan akses tidak sah ke log aktivitas
            ActivityLog::record(
                'akses_ditolak',
                "Percobaan akses tidak sah ke berkas #{$id} ({$type}) oleh user #{$user->id}",
                $pengajuan->id
            );
            abort(403, 'Anda tidak memiliki izin untuk mengakses berkas ini.');
        }

        // 3. Tentukan path file berdasarkan jenis berkas
        $filePath = match ($type) {
            'ktp'       => $pengajuan->file_ktp,
            'kk'        => $pengajuan->file_kk,
            'pengantar' => $pengajuan->file_pengantar,
            'tambahan'  => $pengajuan->file_tambahan,
            default     => null,
        };

        // 4. Validasi: jenis tidak dikenal atau file tidak ada
        if (!$filePath || !Storage::disk('uploads')->exists($filePath)) {
            abort(404, 'Berkas tidak ditemukan.');
        }

        // 5. Catat akses ke log aktivitas
        $keterangan = $user->isAdmin()
            ? "Admin #{$user->id} mengakses berkas {$type} pengajuan #{$pengajuan->id} (a.n. {$pengajuan->user->name})"
            : "Warga #{$user->id} mengakses berkas {$type} pengajuan miliknya #{$pengajuan->id}";

        ActivityLog::record('akses_berkas', $keterangan, $pengajuan->id);

        // 6. Tentukan MIME type dari ekstensi file
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mimeType  = match ($extension) {
            'pdf'       => 'application/pdf',
            'jpg', 'jpeg' => 'image/jpeg',
            'png'       => 'image/png',
            default     => 'application/octet-stream',
        };

        // 7. Stream file — tidak ada URL publik yang bisa ditebak
        return Storage::disk('uploads')->response($filePath, basename($filePath), [
            'Content-Type'              => $mimeType,
            'Content-Disposition'       => 'inline; filename="' . basename($filePath) . '"',
            'X-Content-Type-Options'    => 'nosniff',
            'Cache-Control'             => 'private, no-store',
        ]);
    }
}
