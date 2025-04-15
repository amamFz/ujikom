<?php

namespace Database\Seeders;

use App\Models\JenisPelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisPlgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenis = [
            ['name' => 'Rumah Tangga'],
            ['name' => 'Bisnis'],
            ['name' => 'Industri'],
        ];

        foreach ($jenis as $j) {
            JenisPelanggan::create($j);
        }    }
}
