<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pemakaian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{

    // fungsi ini digunakan untuk menampilkan halaman utama
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

            if (!$pelanggan) {
                return back()->with('error', 'Nomor kontrol tidak ditemukan');
            }

            return back()->with('error', 'Nomor kontrol tidak ditemukan');
        }

        return view('home');
    }

    // fungsi ini digunakan untuk menampilkan halaman pencarian
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

    // fungsi ini digunakan untuk menampilkan halaman pencarian entry pembayaran
    public function search(Request $request)
    {
        if (!$request->has('no_kontrol')) {
            return view('admin.pembayaran.search');
        }

        $pelanggan = Pelanggan::where('no_kontrol', $request->no_kontrol)->first();

        if (!$pelanggan) {
            return back()->withErrors(['no_kontrol' => 'Nomor kontrol tidak ditemukan']);
        }

        // Ambil pemakaian yang akan dibayar
        $currentPemakaian = Pemakaian::query()
            ->where('no_kontrol_id', $request->no_kontrol)
            ->when($request->filled('tahun'), function ($q) use ($request) {
                $q->where('tahun', $request->tahun);
            })
            ->when($request->filled('bulan'), function ($q) use ($request) {
                $q->where('bulan', $request->bulan);
            })
            ->first();

        if (!$currentPemakaian) {
            return back()->with('error', 'Data pemakaian tidak ditemukan');
        }

        // Ambil semua tagihan yang belum dibayar sebelum bulan ini
        $unpaidBills = Pemakaian::where('no_kontrol_id', $request->no_kontrol)
            ->where('is_status', false)
            ->where(function ($query) use ($currentPemakaian) {
                $query->where('tahun', '<', $currentPemakaian->tahun)
                    ->orWhere(function ($q) use ($currentPemakaian) {
                        $q->where('tahun', $currentPemakaian->tahun)
                            ->where('bulan', '<', $currentPemakaian->bulan);
                    });
            })
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Hitung total tagihan
        $totalUnpaid = $unpaidBills->sum('total_bayar');
        $currentBill = $currentPemakaian->total_bayar;
        $grandTotal = $totalUnpaid + $currentBill;

        return view('admin.pembayaran.entry', compact(
            'pelanggan',
            'currentPemakaian',
            'unpaidBills',
            'totalUnpaid',
            'currentBill',
            'grandTotal'
        ));
    }

    // fungsi ini digunakan untuk menyimpan data entry pembayaran
    public function entry(Request $request)
    {
        $request->validate([
            'no_kontrol' => 'required|exists:pelanggans,no_kontrol',
            'pemakaian_ids' => 'required|array',
            'pemakaian_ids.*' => 'exists:pemakaians,id'
        ]);

        // Update status semua tagihan yang dibayar
        Pemakaian::whereIn('id', $request->pemakaian_ids)
            ->update(['is_status' => true]);

        // Ambil pemakaian terakhir untuk struk
        $lastPemakaian = Pemakaian::find($request->pemakaian_ids[count($request->pemakaian_ids) - 1]);

        // Redirect to receipt dengan data tambahan
        return redirect()->route('pembayaran.receipt', [
            'pemakaian' => $lastPemakaian->id,
            'paid_bills' => implode(',', $request->pemakaian_ids)
        ]);
    }

    // fungsi ini digunakan untuk generate struk pembayaran
    public function generateReceipt(Pemakaian $pemakaian, Request $request)
    {
        $pelanggan = $pemakaian->pelanggan;

        // Ambil tagihan saat ini
        $currentPayment = $pemakaian;

        // Ambil semua tagihan yang dibayar (tunggakan)
        $paidBills = Pemakaian::whereIn('id', explode(',', $request->paid_bills))
            ->where('id', '!=', $pemakaian->id) // Exclude current payment
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Hitung total keseluruhan
        $totalPembayaran = $currentPayment->total_bayar + $paidBills->sum('total_bayar');

        $data = [
            'no_kontrol' => $pelanggan->no_kontrol,
            'nama_pelanggan' => $pelanggan->name,
            'alamat' => $pelanggan->alamat,
            'current_payment' => [
                'tahun' => $currentPayment->tahun,
                'bulan' => date('F', mktime(0, 0, 0, $currentPayment->bulan, 1)),
                'meter_awal' => $currentPayment->meter_awal,
                'meter_akhir' => $currentPayment->meter_akhir,
                'jumlah_pakai' => $currentPayment->jumlah_pakai,
                'biaya_beban' => number_format($currentPayment->biaya_beban_pemakai, 0, ',', '.'),
                'biaya_pemakaian' => number_format($currentPayment->biaya_pemakaian, 0, ',', '.'),
                'total_bayar' => number_format($currentPayment->total_bayar, 0, ',', '.')
            ],
            'previous_bills' => $paidBills->map(function ($bill) {
                return [
                    'periode' => date('F Y', mktime(0, 0, 0, $bill->bulan, 1, $bill->tahun)),
                    'jumlah_pakai' => $bill->jumlah_pakai,
                    'biaya_beban' => number_format($bill->biaya_beban_pemakai, 0, ',', '.'),
                    'biaya_pemakaian' => number_format($bill->biaya_pemakaian, 0, ',', '.'),
                    'total' => number_format($bill->total_bayar, 0, ',', '.')
                ];
            })->toArray(),
            'total_pembayaran' => number_format($totalPembayaran, 0, ',', '.'),
            'tanggal_bayar' => now()->format('d/m/Y H:i'),
            // 'petugas' => auth()->user()->name,
        ];

        // Load view dengan data yang telah disiapkan
        $pdf = PDF::loadView('admin.pembayaran.receipt', $data)
            ->setPaper('A4', 'portrait')
            ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download('struk_pembayaran_' . $pelanggan->no_kontrol . '.pdf');
    }
}
