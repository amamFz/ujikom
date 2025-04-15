<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pemakaian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{

    public function index(Request $request)
{
    if ($request->has('no_kontrol')) {
        $pelanggan = Pelanggan::where('no_kontrol', $request->no_kontrol)->first();

        if ($pelanggan) {
            $pemakaians = Pemakaian::where('no_kontrol_id', $pelanggan->no_kontrol)
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get();

            return view('home', compact('pelanggan', 'pemakaians'));
        }

        return back()->with('error', 'Nomor kontrol tidak ditemukan');
    }

    return view('home');
}

    public function searchHistory(Request $request)
    {
        if (!$request->has('no_kontrol')) {
            return view('admin.pembayaran.search-history');
        }

        $request->validate([
            'no_kontrol' => 'required|exists:pelanggans,no_kontrol',
        ]);

        $pelanggan = Pelanggan::where('no_kontrol', $request->no_kontrol)->first();
        $pemakaians = Pemakaian::where('no_kontrol_id', $request->no_kontrol)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        return view('admin.pembayaran.history', compact('pelanggan', 'pemakaians'));
    }

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
        ]);

        $pemakaian = Pemakaian::where('no_kontrol_id', $request->no_kontrol)
            ->where('tahun', $request->tahun)
            ->where('bulan', $request->bulan)
            ->first();

        if (!$pemakaian) {
            return back()->with('error', 'Data pemakaian tidak ditemukan');
        }

        $pemakaian->update([
            'is_status' => true,
        ]);

        // Redirect to receipt
        return redirect()->route('pembayaran.receipt', $pemakaian->id);
    }

    public function generateReceipt(Pemakaian $pemakaian)
    {
        $pelanggan = $pemakaian->pelanggan;

        $data = [
            'no_kontrol' => $pelanggan->no_kontrol,
            'nama_pelanggan' => $pelanggan->name,
            'alamat' => $pelanggan->alamat,
            'tahun' => $pemakaian->tahun,
            'bulan' => date('F', mktime(0, 0, 0, $pemakaian->bulan, 1)),
            'meter_awal' => $pemakaian->meter_awal,
            'meter_akhir' => $pemakaian->meter_akhir,
            'jumlah_pakai' => $pemakaian->jumlah_pakai,
            'biaya_beban' => number_format($pemakaian->biaya_beban_pemakai, 0, ',', '.'),
            'biaya_pemakaian' => number_format($pemakaian->biaya_pemakaian, 0, ',', '.'),
            'total_bayar' => number_format($pemakaian->total_bayar, 0, ',', '.'),
            'status_pembayaran' => $pemakaian->is_status ? 'LUNAS' : 'BELUM LUNAS',
            'tanggal_bayar' => now()->format('d/m/Y H:i'),
        ];

        $pdf = PDF::loadView('admin.pembayaran.receipt', $data);

        return $pdf->download('struk_pembayaran_' . $pelanggan->no_kontrol . '.pdf');
    }
}
