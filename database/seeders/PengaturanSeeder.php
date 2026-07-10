<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengaturan::create([
            'nama_kades' => 'Ade Sudiana',
            'nip_kades' => '19801231 200501 1 001',
            'jabatan' => 'Kepala Desa Babakanmulya',
        ]);
    }
}
