<?php

namespace App\Http\Controllers;

use App\Models\JenisPelanggan;
use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // fungsi ini digunakan untuk menampilkan semua data tarif
    public function index()
    {
        $tarifs = Tarif::with('jenis_pelanggan')->get();
        return view("admin.tarif.index", compact("tarifs"));
    }

    /**
     * Show the form for creating a new resource.
     */
    // fungsi ini digunakan untuk menampilkan form tambah tarif
    public function create()
    {
        $jenis_pelanggans = JenisPelanggan::all();
        return view("admin.tarif.create", compact("jenis_pelanggans"));
    }

    /**
     * Store a newly created resource in storage.
     */
    // fungsi ini digunakan untuk menyimpan data tarif baru
    public function store(Request $request)
    {
        $request->validate([
            'jenis_plg_id' => 'required|exists:jenis_pelanggans,id',
            'biaya_beban' => 'required|numeric|between:0,999999.99',
            'tarif_kwh' => 'required|numeric|between:0,999999.99',
        ]);

        // Convert to 2 decimal places
        $data = $request->all();
        $data['biaya_beban'] = number_format((float) $data['biaya_beban'], 2, '.', '');
        $data['tarif_kwh'] = number_format((float) $data['tarif_kwh'], 2, '.', '');

        Tarif::create($data);
        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    // fungsi ini digunakan untuk menampilkan detail tarif
    public function show(Tarif $tarif)
    {
        $tarif->load('jenis_pelanggan');
        return view("admin.tarif.show", compact("tarif"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // fungsi ini digunakan untuk menampilkan form edit tarif
    public function edit(Tarif $tarif)
    {
        $jenis_pelanggans = JenisPelanggan::all();
        return view("admin.tarif.edit", compact("tarif", "jenis_pelanggans"));
    }

    /**
     * Update the specified resource in storage.
     */
    // fungsi ini digunakan untuk memperbarui data tarif
    public function update(Request $request, Tarif $tarif)
    {
        $request->validate([
            'jenis_plg_id' => 'required|exists:jenis_pelanggans,id',
            'biaya_beban' => 'required|numeric|between:0,999999.99',
            'tarif_kwh' => 'required|numeric|between:0,999999.99',
        ]);

        // Convert to 2 decimal places
        $data = $request->all();
        $data['biaya_beban'] = number_format((float) $data['biaya_beban'], 2, '.', '');
        $data['tarif_kwh'] = number_format((float) $data['tarif_kwh'], 2, '.', '');

        $tarif->update($data);
        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    // fungsi ini digunakan untuk menghapus data tarif
    public function destroy(Tarif $tarif)
    {
        $tarif->delete();
        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil dihapus');
    }
}
