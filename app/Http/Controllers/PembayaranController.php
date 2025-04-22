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

            if (!$pelanggan) {
                return view('home')->with('error', 'Nomor kontrol tidak ditemukan.');
            }

            $pemakaians = Pemakaian::where('no_kontrol_id', $pelanggan->no_kontrol)
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get();

            if ($pemakaians->isEmpty()) {
                return view('home', [
                    'pelanggan' => $pelanggan,
                    'warning' => 'Belum ada data pemakaian untuk pelanggan ini.'
                ]);
            }

            return view('home', compact('pelanggan', 'pemakaians'));
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
        ], [
            'no_kontrol.required' => 'Nomor kontrol harus diisi',
            'no_kontrol.exists' => 'Nomor kontrol tidak ditemukan'
        ]);

        $pelanggan = Pelanggan::where('no_kontrol', $request->no_kontrol)->first();

        if (!$pelanggan) {
            return back()->withErrors(['no_kontrol' => 'Data pelanggan tidak ditemukan'])->withInput();
        }

        $pemakaians = Pemakaian::where('no_kontrol_id', $request->no_kontrol)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        if ($pemakaians->isEmpty()) {
            return view('admin.pembayaran.search-history')
                ->with('warning', 'Belum ada data pemakaian untuk pelanggan ini')
                ->with('input', $request->all());
        }

        return view('admin.pembayaran.history', compact('pelanggan', 'pemakaians'));
    }

    // fungsi ini digunakan untuk menampilkan halaman pencarian entry pembayaran
    public function search(Request $request)
    {
        if (!$request->has('no_kontrol')) {
            return view('admin.pembayaran.search');
        }

        // Validate no_kontrol first
        $pelanggan = Pelanggan::where('no_kontrol', $request->no_kontrol)->first();
        if (!$pelanggan) {
            return back()->withErrors(['no_kontrol' => 'Nomor kontrol tidak ditemukan'])->withInput();
        }

        // Build query
        $query = Pemakaian::query()
            ->where('no_kontrol_id', $request->no_kontrol);

        // Add year and month filters if provided
        if ($request->filled('tahun') && $request->filled('bulan')) {
            $query->where('tahun', $request->tahun)
                  ->where('bulan', $request->bulan);
        }

        // Get the pemakaian data
        $currentPemakaian = $query->first();

        // Check if data exists for the specified period
        if (!$currentPemakaian) {
            $errorMessage = $request->filled('tahun') && $request->filled('bulan')
                ? "Data pemakaian untuk periode " . date('F Y', mktime(0, 0, 0, $request->bulan, 1, $request->tahun)) . " tidak ditemukan"
                : "Data pemakaian tidak ditemukan";

            return back()
                ->withErrors(['period' => $errorMessage])
                ->withInput();
        }

        // Get unpaid bills before current period
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

        // Calculate totals
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
