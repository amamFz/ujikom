<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarifs = Tarif::all();
        return view("admin.tarif.index", compact("tarifs"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.tarif.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_plg' => 'required|unique:tarifs,jenis_plg',
            'biaya_beban' => 'required|numeric|between:0,999999.99',
            'tarif_kwh' => 'required|numeric|between:0,999999.99',
        ]);

        // Convert to 2 decimal places
        $data = $request->all();
        $data['biaya_beban'] = number_format((float)$data['biaya_beban'], 2, '.', '');
        $data['tarif_kwh'] = number_format((float)$data['tarif_kwh'], 2, '.', '');

        Tarif::create($data);
        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarif $tarif)
    {
        $tarifs = Tarif::all();
        return view("admin.tarif.show", compact("tarif"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarif $tarif)
    {
        $tarifs = Tarif::all();
        return view("admin.tarif.edit", compact("tarif"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarif $tarif)
    {
        $request->validate([
            'jenis_plg' => 'required|unique:tarifs,jenis_plg,' . $tarif->id,
            'biaya_beban' => 'required|numeric|between:0,999999.99',
            'tarif_kwh' => 'required|numeric|between:0,999999.99',
        ]);

        // Convert to 2 decimal places
        $data = $request->all();
        $data['biaya_beban'] = number_format((float)$data['biaya_beban'], 2, '.', '');
        $data['tarif_kwh'] = number_format((float)$data['tarif_kwh'], 2, '.', '');

        $tarif->update($data);
        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarif $tarif)
    {
        $tarif->delete();
        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil dihapus');
    }
}
