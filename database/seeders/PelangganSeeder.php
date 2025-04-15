<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelanggan_data = [
            [
                'no_kontrol' => 'NOPLG001',
                'name' => 'Ahmad Sudrajat',
                'alamat' => 'Jl. Merdeka No. 123, Bandung',
                'telepon' => '081234567890',
                'jenis_plg_id' => 1, // Rumah Tangga
            ],
            [
                'no_kontrol' => 'NOPLG002',
                'name' => 'Toko Makmur Jaya',
                'alamat' => 'Jl. Sudirman No. 45, Bandung',
                'telepon' => '081234567891',
                'jenis_plg_id' => 2, // Bisnis
            ],
            [
                'no_kontrol' => 'NOPLG003',
                'name' => 'PT. Maju Bersama',
                'alamat' => 'Jl. Gatot Subroto No. 67, Bandung',
                'telepon' => '081234567892',
                'jenis_plg_id' => 3, // Industri
            ],
        ];

        foreach ($pelanggan_data as $data) {
            Pelanggan::create($data);
        }
    }
}
