<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $fillable = [
        "jenis_plg",
        "biaya_beban",
        "tarif_kwh",
    ];

    public function pelanggans()
    {
        return $this->hasMany(Pelanggan::class, 'jenis_plg_id');
    }
}
