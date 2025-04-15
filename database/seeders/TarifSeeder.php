<?php

namespace Database\Seeders;

use App\Models\Tarif;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TarifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tarifs = [
            [
                'jenis_plg_id' => 1,
                'biaya_beban' => 20000,
                'tarif_kwh' => 1352.00,
            ],
            [
                'jenis_plg_id' => 2,
                'biaya_beban' => 30000,
                'tarif_kwh' => 1467.28,
            ],
            [
                'jenis_plg_id' => 3,
                'biaya_beban' => 50000,
                'tarif_kwh' => 1699.53,
            ],
        ];

        foreach ($tarifs as $tarif) {
            Tarif::create($tarif);
        }
    }
}
