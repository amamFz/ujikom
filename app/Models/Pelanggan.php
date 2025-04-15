<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    // Model ini digunakan untuk mengelola data pelanggan
    protected $fillable = [
        'no_kontrol',
        'name',
        'alamat',
        'telepon',
        'jenis_plg_id'
    ];

    // Model ini digunakan untuk mengelola relasi ke tabel tarif
    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'jenis_plg_id');
    }


    // fungsi ini digunakan untuk menggenerate nomor kontrol yang unik
    public static function generateUniqueNoKontrol()
    {
        $prefix = 'NOPLG';
        do{
            $randomString = $prefix . mt_rand(1000, 9999);
        }while(self::where('no_kontrol', $randomString)->exists());

        return $randomString;
    }
}
