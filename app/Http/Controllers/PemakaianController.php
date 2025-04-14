<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\pemakaian;
use Illuminate\Http\Request;

class PemakaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemakaians = pemakaian::with('pelanggan')->get();
        return view('admin.pemakaian.index', compact('pemakaians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggans = Pelanggan::all();
        return view('admin.pemakaian.create', compact('pelanggans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'tahun' => 'required|integer',
            'bulan' => 'required|integer|between:1,12',
            'no_kontrol_id' => 'required|exists:pelanggans,no_kontrol',
            'meter_awal' => 'required|integer|min:0',
            'meter_akhir' => 'required|integer|gte:meter_awal',
        ]);

        // Find pelanggan with their tarif relationship
        $pelanggan = Pelanggan::with('tarif')
            ->where('no_kontrol', $validated['no_kontrol_id'])
            ->firstOrFail(); // This will automatically return 404 if not found

        // Calculate usage (pemakaian)
        $jumlah_pakai = $request->meter_akhir - $request->meter_awal;
        if ($jumlah_pakai < 0) {
            return redirect()->back()->withErrors(['meter_akhir' => 'Meter akhir harus lebih besar dari meter awal']);
        }
        // Set the biaya beban and biaya pemakaian
        $biaya_beban_pemakai = $pelanggan->tarif->biaya_beban;
        $biaya_pemakaian = $jumlah_pakai * $pelanggan->tarif->tarif_kwh;

        // Create new pemakaian record
        Pemakaian::create([
            'tahun' => $validated['tahun'],
            'bulan' => $validated['bulan'],
            'no_kontrol_id' => $pelanggan->no_kontrol,
            'meter_awal' => $validated['meter_awal'],
            'meter_akhir' => $validated['meter_akhir'],
            'jumlah_pakai' => $jumlah_pakai,
            'biaya_beban_pemakai' => $biaya_beban_pemakai,
            'biaya_pemakaian' => $biaya_pemakaian,
        ]);

        // Redirect with success message
        return redirect()->route('pemakaian.index')
            ->with('success', 'Data pemakaian berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(pemakaian $pemakaian)
    {
        $pemakaian->load('pelanggan');
        return view('admin.pemakaian.show', compact('pemakaian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pemakaian $pemakaian)
    {
        $pelanggans = Pelanggan::all();
        $pemakaian->load('pelanggan');
        return view('admin.pemakaian.edit', compact('pemakaian', 'pelanggans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pemakaian $pemakaian)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'bulan' => 'required|integer|between:1,12',
            'no_kontrol_id' => 'required|exists:pelanggans,no_kontrol',
            'meter_awal' => 'required|integer|min:0',
            'meter_akhir' => 'required|integer|gte:meter_awal',
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
        dd($pelanggan->tarif);
        $pemakaian->update([
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'no_kontrol_id' => $request->no_kontrol_id,
            'meter_awal' => $request->meter_awal,
            'meter_akhir' => $request->meter_akhir,
            'jumlah_pakai' => $jumlah_pakai,
            'biaya_beban_pemakai' => $biaya_beban_pemakai,
            'biaya_pemakaian' => $biaya_pemakaian
        ]);

        return redirect()->route('pemakaian.index')
            ->with('success', 'Data pemakaian berhasil diperbarui');}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pemakaian $pemakaian)
    {
        $pemakaian->delete();
        return redirect()->route('pemakaian.index')->with('success', 'Data pemakaian berhasil dihapus');
    }
}
