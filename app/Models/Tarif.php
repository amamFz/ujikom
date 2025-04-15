<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    // Model ini digunakan untuk mengelola data tarif
    protected $fillable = [
        "jenis_plg_id",
        "biaya_beban",
        "tarif_kwh",
    ];

    // Model ini digunakan untuk mengelola relasi ke tabel pelanggan
    public function pelanggans()
    {
        return $this->hasMany(Pelanggan::class, 'jenis_plg_id');
    }

    public function jenis_pelanggan()
    {
        return $this->belongsTo(JenisPelanggan::class, 'jenis_plg_id');
    }

    // public function jenis_plg()
    // {
    //     return $this->hasMany(Pelanggan::class);
    // }
}
