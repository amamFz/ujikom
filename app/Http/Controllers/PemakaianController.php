<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\pemakaian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PemakaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // fungsi ini digunakan untuk menampilkan semua data pemakaian
    public function index(Request $request)
    {
        $query = Pemakaian::with(['pelanggan.tarif'])
            ->when($request->tahun, function ($q) use ($request) {
                return $q->where('tahun', $request->tahun);
            })
            ->when($request->bulan, function ($q) use ($request) {
                return $q->where('bulan', $request->bulan);
            })
            ->when($request->status !== null, function ($q) use ($request) {
                return $q->where('is_status', $request->status);
            });

        $pemakaians = $query->latest()->paginate(10);

        return view('admin.pemakaian.index', compact('pemakaians'));
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2020|max:' . date('Y'),
            'bulan' => 'required|integer|min:1|max:12',
            'status' => 'nullable|in:0,1'
        ]);

        $query = Pemakaian::with(['pelanggan.jenis_pelanggan', 'pelanggan.tarif'])
            ->when($request->tahun, function ($q) use ($request) {
                return $q->where('tahun', $request->tahun);
            })
            ->when($request->bulan, function ($q) use ($request) {
                return $q->where('bulan', $request->bulan);
            })
            ->when($request->status !== null, function ($q) use ($request) {
                return $q->where('is_status', $request->status);
            });

        $pemakaians = $query->get();

        if ($pemakaians->isEmpty()) {
            return back()->with('error', 'Tidak ada data pemakaian untuk periode yang dipilih');
        }

        $data = [
            'pemakaians' => $pemakaians,
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'status' => $request->status
        ];

        $pdf = PDF::loadView('admin.pemakaian.filterReport', $data);

        $filename = sprintf(
            'laporan-pemakaian-%s-%s.pdf',
            $request->tahun,
            str_pad($request->bulan, 2, '0', STR_PAD_LEFT)
        );

        return $pdf->stream($filename);
    }
    /**
     * Show the form for creating a new resource.
     */

    // fungsi ini digunakan untuk menampilkan form tambah pemakaian
    public function create(Request $request)
{
    $pelanggans = Pelanggan::all();
    $tahun = $request->tahun ?? date('Y');
    $bulan = $request->bulan ?? date('n');
    $no_kontrol_id = $request->no_kontrol_id;
    $meter_awal = null;
    $biaya_beban_pemakai = null;

    if ($no_kontrol_id) {
        // Ambil data pelanggan beserta tarifnya
        $pelanggan = Pelanggan::with('tarif')
            ->where('no_kontrol', $no_kontrol_id)
            ->first();

        // Set biaya beban dari tarif pelanggan
        if ($pelanggan && $pelanggan->tarif) {
            $biaya_beban_pemakai = $pelanggan->tarif->biaya_beban;
        }

        // Cari data meter akhir sebelumnya
        if ($tahun && $bulan) {
            $prevMonth = $bulan == 1 ? 12 : $bulan - 1;
            $prevYear = $bulan == 1 ? $tahun - 1 : $tahun;

            $lastReading = Pemakaian::where('no_kontrol_id', $no_kontrol_id)
                ->where('tahun', $prevYear)
                ->where('bulan', $prevMonth)
                ->first();

            if ($lastReading) {
                $meter_awal = $lastReading->meter_akhir;
            }
        }
    }

    return view('admin.pemakaian.create', compact(
        'pelanggans',
        'tahun',
        'bulan',
        'no_kontrol_id',
        'meter_awal',
        'biaya_beban_pemakai'
    ));
}

    public function getLastMeterAkhir(Request $request)
    {
        if (!$request->no_kontrol_id || !$request->tahun || !$request->bulan) {
            return response()->json(['meter_akhir' => null]);
        }

        // Hitung bulan dan tahun sebelumnya
        $prevMonth = $request->bulan == 1 ? 12 : $request->bulan - 1;
        $prevYear = $request->bulan == 1 ? $request->tahun - 1 : $request->tahun;

        // Cari data pemakaian terakhir untuk pelanggan tersebut di bulan sebelumnya
        $lastReading = Pemakaian::where('no_kontrol_id', $request->no_kontrol_id)
            ->where('tahun', $prevYear)
            ->where('bulan', $prevMonth)
            ->first();

        return response()->json([
            'meter_akhir' => $lastReading ? $lastReading->meter_akhir : null,
            'is_first_entry' => !$lastReading
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    //  fungsi ini digunakan untuk menyimpan data pemakaian baru
    public function store(Request $request)
    {
        // Get last reading for this customer
        $lastReading = Pemakaian::where('no_kontrol_id', $request->no_kontrol_id)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->first();

        // Different validation rules based on whether this is first entry or not
        $validationRules = [
            'tahun' => 'required|integer',
            'bulan' => 'required|integer|between:1,12',
            'no_kontrol_id' => 'required|exists:pelanggans,no_kontrol',
            'meter_akhir' => 'required|integer|min:0',
        ];

        // Add meter_awal validation only if this is first entry
        if (!$lastReading) {
            $validationRules['meter_awal'] = 'required|integer|min:0';
        }

        $validated = $request->validate($validationRules);

        // Check for duplicate entry
        $exists = Pemakaian::where('no_kontrol_id', $validated['no_kontrol_id'])
            ->where('tahun', $validated['tahun'])
            ->where('bulan', $validated['bulan'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['duplicate' => 'Data pemakaian untuk pelanggan ini pada periode tersebut sudah ada']);
        }

        // Set meter_awal based on whether this is first entry or not
        $meter_awal = $lastReading ? $lastReading->meter_akhir : $request->meter_awal;

        if ($validated['meter_akhir'] <= $meter_awal) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['meter_akhir' => 'Meter akhir harus lebih besar dari meter awal (' . $meter_awal . ')']);
        }

        // Find pelanggan with tarif
        $pelanggan = Pelanggan::with('tarif')
            ->where('no_kontrol', $validated['no_kontrol_id'])
            ->firstOrFail();

        // Calculate usage and costs
        $jumlah_pakai = $validated['meter_akhir'] - $meter_awal;
        $biaya_beban_pemakai = $pelanggan->tarif->biaya_beban ?? 0;
        $biaya_pemakaian = $jumlah_pakai * $pelanggan->tarif->tarif_kwh;

        // Create new pemakaian record
        Pemakaian::create([
            'tahun' => $validated['tahun'],
            'bulan' => $validated['bulan'],
            'no_kontrol_id' => $pelanggan->no_kontrol,
            'meter_awal' => $meter_awal,
            'meter_akhir' => $validated['meter_akhir'],
            'jumlah_pakai' => $jumlah_pakai,
            'biaya_beban_pemakai' => $biaya_beban_pemakai,
            'biaya_pemakaian' => $biaya_pemakaian,
        ]);

        return redirect()->route('pemakaian.index')
            ->with('success', 'Data pemakaian berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */

    //  fungsi ini digunakan untuk menampilkan detail pemakaian
    public function show(pemakaian $pemakaian)
    {
        $pemakaian->load('pelanggan');
        return view('admin.pemakaian.show', compact('pemakaian'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    //  fungsi ini digunakan untuk menampilkan form edit pemakaian
    public function edit(pemakaian $pemakaian)
    {
        $pelanggans = Pelanggan::all();
        $pemakaian->load('pelanggan');
        return view('admin.pemakaian.edit', compact('pemakaian', 'pelanggans'));
    }

    /**
     * Update the specified resource in storage.
     */

    //  fungsi ini digunakan untuk memperbarui data pemakaian
    public function update(Request $request, pemakaian $pemakaian)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'bulan' => 'required|integer|between:1,12',
            'no_kontrol_id' => 'required|exists:pelanggans,no_kontrol',
            'meter_awal' => 'required|integer|min:0',
            'meter_akhir' => 'required|integer|gte:meter_awal',
            'is_status' => 'required|boolean',
        ]);

        // Find pelanggan with tarif
        $pelanggan = Pelanggan::with('tarif')
            ->where('no_kontrol', $request->no_kontrol_id)
            ->firstOrFail();

        // Calculate jumlah_pakai
        $jumlah_pakai = $request->meter_akhir - $request->meter_awal;

        // Calculate biaya
        $biaya_beban_pemakai = $pelanggan->tarif->biaya_beban ?? 0;
        $biaya_pemakaian = $jumlah_pakai * $pelanggan->tarif->tarif_kwh;

        $pemakaian->update([
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'no_kontrol_id' => $request->no_kontrol_id,
            'meter_awal' => $request->meter_awal,
            'meter_akhir' => $request->meter_akhir,
            'jumlah_pakai' => $jumlah_pakai,
            'biaya_beban_pemakai' => $biaya_beban_pemakai,
            'biaya_pemakaian' => $biaya_pemakaian,
            'is_status' => $request->is_status
        ]);

        return redirect()->route('pemakaian.index')
            ->with('success', 'Data pemakaian berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */

    //  fungsi ini digunakan untuk menghapus data pemakaian
    public function destroy(pemakaian $pemakaian)
    {
        $pemakaian->delete();
        return redirect()->route('pemakaian.index')->with('success', 'Data pemakaian berhasil dihapus');
    }

    /**
     * Generate PDF for pemakaian
     */
    public function pemakaianPdf($id)
    {
        $pemakaian = Pemakaian::with(['pelanggan.jenis_pelanggan', 'pelanggan.tarif'])
            ->findOrFail($id);

        $data = [
            'pemakaians' => collect([$pemakaian]),
            'tahun' => $pemakaian->tahun,
            'bulan' => $pemakaian->bulan,
            'summary' => [
                'total_pemakaian' => $pemakaian->jumlah_pakai,
                'total_biaya_beban' => $pemakaian->biaya_beban_pemakai,
                'total_biaya_pemakaian' => $pemakaian->biaya_pemakaian,
                'total_bayar' => $pemakaian->total_bayar,
            ],
            'single' => true,
        ];

        $pdf = PDF::loadView('admin.pemakaian.report', $data);

        return $pdf->stream("pemakaian-{$id}.pdf");
    }

    /**
     * Generate PDF for all pemakaian
     */
    public function generateAllReport()
    {
        // Ambil semua data pemakaian
        $pemakaians = Pemakaian::with('pelanggan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

        // Generate PDF menggunakan view
        $pdf = Pdf::loadView('admin.pemakaian.report-all', compact('pemakaians'));

        // Unduh file PDF
        return $pdf->download('laporan-pemakaian-semua.pdf');
    }
}
