<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemakaian extends Model
{
    protected $fillable = [
        'tahun',
        'bulan',
        'no_kontrol_id',
        'meter_awal',
        'meter_akhir',
        'jumlah_pakai',
        'biaya_beban_pemakai',
        'biaya_pemakaian',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'bulan' => 'integer',
        'meter_awal' => 'integer',
        'meter_akhir' => 'integer',
        'jumlah_pakai' => 'integer',
        'biaya_beban_pemakai' => 'decimal:2',
        'biaya_pemakaian' => 'decimal:2',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'no_kontrol_id', 'no_kontrol');
    }
}
