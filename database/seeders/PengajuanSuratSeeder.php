<?php

namespace Database\Seeders;

use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Database\Seeder;

class PengajuanSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wargaIds = User::where('role', 'warga')->pluck('id')->toArray();

        if (empty($wargaIds)) {
            return;
        }

        $pengajuanData = [
            [
                'user_id' => $wargaIds[0],
                'jenis_surat' => 'SKTM',
                'keperluan' => 'Untuk persyaratan beasiswa kuliah',
                'file_ktp' => 'ktp/sample_ktp_1.jpg',
                'file_pengantar' => 'pengantar/sample_pengantar_1.jpg',
                'file_tambahan' => null,
                'tgl_pengajuan' => now()->subDays(10)->toDateString(),
                'status' => 'Selesai',
                'keterangan_admin' => 'Surat sudah disetujui dan siap dicetak.',
            ],
            [
                'user_id' => $wargaIds[0],
                'jenis_surat' => 'Domisili',
                'keperluan' => 'Untuk pembuatan KTP baru',
                'file_ktp' => 'ktp/sample_ktp_2.jpg',
                'file_pengantar' => null,
                'file_tambahan' => null,
                'tgl_pengajuan' => now()->subDays(5)->toDateString(),
                'status' => 'Menunggu',
                'keterangan_admin' => null,
            ],
            [
                'user_id' => $wargaIds[1] ?? $wargaIds[0],
                'jenis_surat' => 'SKU',
                'keperluan' => 'Untuk pengajuan pinjaman modal usaha',
                'file_ktp' => 'ktp/sample_ktp_3.jpg',
                'file_pengantar' => 'pengantar/sample_pengantar_2.jpg',
                'file_tambahan' => 'tambahan/sample_foto_usaha.jpg',
                'tgl_pengajuan' => now()->subDays(3)->toDateString(),
                'status' => 'Diproses',
                'keterangan_admin' => 'Sedang diverifikasi oleh admin.',
            ],
            [
                'user_id' => $wargaIds[1] ?? $wargaIds[0],
                'jenis_surat' => 'SKTM',
                'keperluan' => 'Untuk persyaratan bantuan sosial',
                'file_ktp' => 'ktp/sample_ktp_4.jpg',
                'file_pengantar' => 'pengantar/sample_pengantar_3.jpg',
                'file_tambahan' => null,
                'tgl_pengajuan' => now()->subDays(1)->toDateString(),
                'status' => 'Selesai',
                'keterangan_admin' => 'Disetujui.',
            ],
            [
                'user_id' => $wargaIds[2] ?? $wargaIds[0],
                'jenis_surat' => 'Domisili',
                'keperluan' => 'Untuk pendaftaran sekolah',
                'file_ktp' => 'ktp/sample_ktp_5.jpg',
                'file_pengantar' => null,
                'file_tambahan' => null,
                'tgl_pengajuan' => now()->toDateString(),
                'status' => 'Menunggu',
                'keterangan_admin' => null,
            ],
        ];

        foreach ($pengajuanData as $data) {
            PengajuanSurat::create($data);
        }
    }
}
