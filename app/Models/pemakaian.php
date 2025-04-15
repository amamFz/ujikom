<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemakaian extends Model
{
    // Model ini digunakan untuk mengelola data pemakaian
    protected $fillable = [
        'tahun',
        'bulan',
        'no_kontrol_id',
        'meter_awal',
        'meter_akhir',
        'jumlah_pakai',
        'biaya_beban_pemakai',
        'biaya_pemakaian',
        'total_bayar',
        'is_status',
    ];

    // Model ini untuk mengelola relasi ke tabel pelanggan
    protected $casts = [
        'tahun' => 'integer',
        'bulan' => 'integer',
        'meter_awal' => 'integer',
        'meter_akhir' => 'integer',
        'jumlah_pakai' => 'integer',
        'biaya_beban_pemakai' => 'decimal:2',
        'biaya_pemakaian' => 'decimal:2',
        'total_bayar' => 'decimal:2',
        'is_status' => 'boolean',
    ];

    // Model ini digunakan untuk mengelola relasi ke tabel pelanggan
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'no_kontrol_id', 'no_kontrol');
    }
}
