<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanSurat extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'pengajuan_surats';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'jenis_surat',
        'keperluan',
        'file_ktp',
        'file_pengantar',
        'file_tambahan',
        'file_kk',
        'tgl_pengajuan',
        'status',
        'keterangan_admin',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tgl_pengajuan' => 'date',
        ];
    }

    /**
     * Get the user that owns the pengajuan surat.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
