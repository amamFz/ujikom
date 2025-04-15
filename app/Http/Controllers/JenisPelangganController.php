<?php

namespace App\Http\Controllers;

use App\Models\JenisPelanggan;
use Illuminate\Http\Request;

class JenisPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggans = JenisPelanggan::all();
        return view("admin.jenisPelanggan.index", compact("pelanggans"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggans = JenisPelanggan::all();
        return view("admin.jenisPelanggan.create", compact("pelanggans"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        JenisPelanggan::create($request->all());
        return redirect()->route('jenis_pelanggan.index')->with('success', 'Jenis Pelanggan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisPelanggan $jenisPelanggan)
    {
        $pelanggans = JenisPelanggan::all();
        return view("admin.jenisPelanggan.show", compact("jenisPelanggan"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisPelanggan $jenisPelanggan)
    {
        $pelanggans = JenisPelanggan::all();
        return view("admin.jenisPelanggan.edit", compact("jenisPelanggan"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisPelanggan $jenisPelanggan)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:jenis_pelanggans,name,' . $jenisPelanggan->id
        ]);

        $jenisPelanggan->update($request->all());
        return redirect()->route('jenis_pelanggan.index')
            ->with('success', 'Jenis Pelanggan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisPelanggan $jenisPelanggan)
    {
        $jenisPelanggan->delete();
        return redirect()->route('jenis_pelanggan.index')->with('success', 'Jenis Pelanggan berhasil dihapus');
    }
}
