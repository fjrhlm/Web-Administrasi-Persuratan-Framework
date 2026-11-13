<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'aksi',
        'keterangan',
        'pengajuan_id',
        'ip_address',
        'user_agent',
    ];

    /**
     * Relasi ke user yang melakukan aktivitas.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke pengajuan surat (opsional).
     */
    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }

    /**
     * Helper statik untuk mencatat aktivitas dengan mudah dari mana saja.
     *
     * @param string   $aksi         Jenis aksi (contoh: 'login', 'pengajuan_baru', 'ubah_status')
     * @param string   $keterangan   Deskripsi detail aktivitas
     * @param int|null $pengajuanId  ID pengajuan surat terkait (opsional)
     */
    public static function record(string $aksi, string $keterangan, ?int $pengajuanId = null): self
    {
        return self::create([
            'user_id'      => Auth::id(),
            'aksi'         => $aksi,
            'keterangan'   => $keterangan,
            'pengajuan_id' => $pengajuanId,
            'ip_address'   => Request::ip(),
            'user_agent'   => Request::userAgent(),
        ]);
    }

    /**
     * Label warna badge berdasarkan jenis aksi (untuk tampilan di view).
     */
    public function getBadgeColorAttribute(): string
    {
        return match ($this->aksi) {
            'login'          => 'bg-green-100 text-green-700',
            'login_gagal'    => 'bg-red-100 text-red-700',
            'logout'         => 'bg-gray-100 text-gray-600',
            'pengajuan_baru' => 'bg-blue-100 text-blue-700',
            'ubah_status'    => 'bg-purple-100 text-purple-700',
            'ubah_password'  => 'bg-blue-100 text-blue-700',
            'akses_berkas'   => 'bg-amber-100 text-amber-700',
            'akses_ditolak'  => 'bg-red-200 text-red-800',
            'cetak_surat'    => 'bg-indigo-100 text-indigo-700',
            default          => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Label ikon berdasarkan jenis aksi.
     */
    public function getIconAttribute(): string
    {
        return match ($this->aksi) {
            'login'          => '[OK]',
            'login_gagal'    => '[GAGAL]',
            'logout'         => '[KELUAR]',
            'pengajuan_baru' => '[BARU]',
            'ubah_status'    => '[UPDATE]',
            'ubah_password'  => '[KUNCI]',
            'akses_berkas'   => '[FILE]',
            'akses_ditolak'  => '[TOLAK]',
            'cetak_surat'    => '[CETAK]',
            default          => '[LOG]',
        };
    }
}
