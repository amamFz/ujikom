<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = [
        'no_kontrol',
        'name',
        'alamat',
        'telepon',
        'jenis_plg_id'
    ];

    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'jenis_plg_id');
    }



    public static function generateUniqueNoKontrol()
    {
        $prefix = 'NOPLG';
        do{
            $randomString = $prefix . mt_rand(1000, 9999);
        }while(self::where('no_kontrol', $randomString)->exists());

        return $randomString;
    }
}
