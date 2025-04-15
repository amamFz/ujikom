<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use App\Models\Pemakaian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemakaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelanggan_list = Pelanggan::all();
        $current_month = date('n');
        $current_year = date('Y');

        foreach ($pelanggan_list as $pelanggan) {
            // Create 6 months of usage data for each customer
            for ($i = 0; $i < 6; $i++) {
                $month = $current_month - $i;
                $year = $current_year;

                // Adjust year if month goes below 1
                if ($month < 1) {
                    $month += 12;
                    $year--;
                }

                $meter_awal = $i * 100;
                $meter_akhir = ($i + 1) * 100;
                $jumlah_pakai = $meter_akhir - $meter_awal;

                $biaya_beban = $pelanggan->tarif->biaya_beban;
                $biaya_pemakaian = $jumlah_pakai * $pelanggan->tarif->tarif_kwh;

                Pemakaian::create([
                    'tahun' => $year,
                    'bulan' => $month,
                    'no_kontrol_id' => $pelanggan->no_kontrol,
                    'meter_awal' => $meter_awal,
                    'meter_akhir' => $meter_akhir,
                    'jumlah_pakai' => $jumlah_pakai,
                    'biaya_beban_pemakai' => $biaya_beban,
                    'biaya_pemakaian' => $biaya_pemakaian,
                    'is_status' => $i > 1 ? true : false, // Only last 2 months unpaid
                ]);
            }
        }
    }
}
