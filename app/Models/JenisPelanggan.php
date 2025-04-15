<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPelanggan extends Model
{
    protected $fillable = [
        'name'
    ];

    public function tarifs()
    {
        return $this->hasMany(Tarif::class);
    }

    public function pelanggans()
    {
        return $this->hasMany(Pelanggan::class, 'jenis_plg_id');
    }
}
