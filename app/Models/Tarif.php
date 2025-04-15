<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    // Model ini digunakan untuk mengelola data tarif
    protected $fillable = [
        "jenis_plg",
        "biaya_beban",
        "tarif_kwh",
    ];

    // Model ini digunakan untuk mengelola relasi ke tabel pelanggan
    public function pelanggans()
    {
        return $this->hasMany(Pelanggan::class, 'jenis_plg_id');
    }
}
