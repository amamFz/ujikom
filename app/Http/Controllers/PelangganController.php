<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Tarif;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // fungsi ini digunakan untuk menampilkan semua data pelanggan
    public function index()
    {
        $pelanggans = Pelanggan::with('tarif')->get();
        return view('admin.kartuPelanggan.index', compact('pelanggans'));
    }

    /**
     * Show the form for creating a new resource.
     */

    //  fungsi ini digunakan untuk menampilkan form tambah pelanggan
    public function create()
    {
        $no_kontrol = Pelanggan::generateUniqueNoKontrol();
        $tarifs =  Tarif::all();
        return view('admin.kartuPelanggan.create', compact('no_kontrol', 'tarifs'));
    }

    /**
     * Store a newly created resource in storage.
     */

    //  fungsi ini digunakan untuk menyimpan data pelanggan baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'alamat' => 'nullable|min:2|max:512',
            'telepon' => 'required|digits_between:8,16',
            'jenis_plg_id' => 'required|exists:tarifs,id',
        ]);

        $data = $request->all();
        $data['no_kontrol'] = Pelanggan::generateUniqueNoKontrol();

        Pelanggan::create($data);
        return redirect()->route('pelanggan.index')->with('success', 'Kartu pelanggan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */

    //  fungsi ini digunakan untuk menampilkan detail pelanggan
    public function show(Pelanggan $pelanggan)
    {
        $pelanggan->load('tarif');
        return view('admin.kartuPelanggan.show', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    //  fungsi ini digunakan untuk menampilkan form edit pelanggan
    public function edit(Pelanggan $pelanggan)
    {
        // $pelanggans = Pelanggan::all();
        $tarifs = Tarif::all();
        return view('admin.kartuPelanggan.edit', compact('pelanggan', 'tarifs'));
    }

    /**
     * Update the specified resource in storage.
     */

    //  fungsi ini digunakan untuk memperbarui data pelanggan
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'alamat' => 'nullable|min:2|max:512',
            'telepon' => 'required|digits_between:8,16',
            'jenis_plg_id' => 'required|exists:tarifs,id',
        ]);
        $data = $request->except(['no_kontrol', '_token', '_method']);
        $pelanggan->update($data);

        return redirect()->route('pelanggan.index')->with('success', 'Kartu pelanggan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */

    //  fungsi ini digunakan untuk menghapus data pelanggan
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Kartu pelanggan berhasil dihapus');
    }
}
