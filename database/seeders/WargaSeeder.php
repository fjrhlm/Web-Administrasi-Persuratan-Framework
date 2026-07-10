<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wargaData = [
            [
                'nik' => '3578102105880003',
                'name' => 'FAJAR HALIM',
                'email' => 'fajar@example.com',
                'password' => Hash::make('123'),
                'role' => 'warga',
                'no_hp' => '089636975984',
                'alamat' => 'Dusun Parenca RT14 RW05',
                'tempat_tgl_lahir' => 'Kuningan 15 Maret 2006',
                'pekerjaan' => 'Mahasiswa',
                'agama' => 'Islam',
                'email_verified_at' => now(),
            ],
            [
                'nik' => '3208101504980001',
                'name' => 'Budi',
                'email' => 'budi@example.com',
                'password' => Hash::make('123'),
                'role' => 'warga',
                'no_hp' => '087654575645',
                'alamat' => 'Dusun Cirabak RT/RW 01/1',
                'tempat_tgl_lahir' => 'Kuningan 20 Maret 2000',
                'pekerjaan' => 'Buruh Tani',
                'agama' => 'Islam',
                'email_verified_at' => now(),
            ],
            [
                'nik' => '3208101504980004',
                'name' => 'Agus',
                'email' => 'agus@example.com',
                'password' => Hash::make('123'),
                'role' => 'warga',
                'no_hp' => '087654575645',
                'alamat' => 'Dusun Cirabak RT/RW 01/1',
                'tempat_tgl_lahir' => 'Kuningan 10 Mei 2006',
                'pekerjaan' => 'Mahasiswa',
                'agama' => 'Islam',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($wargaData as $warga) {
            User::create($warga);
        }
    }
}
