<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pemakaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{

    public function search(Request $request)
    {
        Log::info('Request data:', $request->all());

        if (!$request->has('no_kontrol')) {
            return view('admin.pembayaran.search');
        }

        $request->validate([
            'no_kontrol' => 'required|exists:pelanggans,no_kontrol',
        ]);

        $pelanggan = Pelanggan::where('no_kontrol', $request->no_kontrol)->first();
        $pemakaian = Pemakaian::where('no_kontrol_id', $request->no_kontrol)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->first();

        return view('admin.pembayaran.entry', compact('pelanggan', 'pemakaian'));
    }

    public function entry(Request $request)
    {
        $request->validate([
            'no_kontrol' => 'required|exists:pelanggans,no_kontrol',
            'jumlah_bayar' => 'required|numeric|min:0',
        ]);

        // Update data pemakaian dengan jumlah bayar
        Pemakaian::where('no_kontrol_id', $request->no_kontrol)
            ->where('tahun', $request->tahun)
            ->where('bulan', $request->bulan)
            ->update([
                'biaya_pemakaian' => $request->jumlah_bayar,
            ]);

        return redirect()->route('pembayaran.search')->with('success', 'Pembayaran berhasil disimpan.');
    }
}
