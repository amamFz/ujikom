<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\JenisPelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Load pelanggan with its jenis_pelanggan
        $pelanggans = Pelanggan::with('jenis_pelanggan')->get();
        return view('admin.kartuPelanggan.index', compact('pelanggans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $no_kontrol = Pelanggan::generateUniqueNoKontrol();
        // Get all jenis_pelanggan
        $jenis_pelanggans = JenisPelanggan::all();
        return view('admin.kartuPelanggan.create', compact('no_kontrol', 'jenis_pelanggans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'alamat' => 'nullable|min:2|max:512',
            'telepon' => 'required|digits_between:8,16',
            'jenis_plg_id' => 'required|exists:jenis_pelanggans,id', // Corrected to check jenis_pelanggans table
        ]);

        $data = $request->all();
        $data['no_kontrol'] = Pelanggan::generateUniqueNoKontrol();

        Pelanggan::create($data);
        return redirect()->route('pelanggan.index')->with('success', 'Kartu pelanggan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        // Load jenis_pelanggan for the pelanggan
        $pelanggan->load('jenis_pelanggan');
        return view('admin.kartuPelanggan.show', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelanggan $pelanggan)
    {
        $jenis_pelanggans = JenisPelanggan::all();
        return view('admin.kartuPelanggan.edit', compact('pelanggan', 'jenis_pelanggans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'alamat' => 'nullable|min:2|max:512',
            'telepon' => 'required|digits_between:8,16',
            'jenis_plg_id' => 'required|exists:jenis_pelanggans,id', // Corrected to check jenis_pelanggans table
        ]);

        $data = $request->except(['no_kontrol', '_token', '_method']);
        $pelanggan->update($data);

        return redirect()->route('pelanggan.index')->with('success', 'Kartu pelanggan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Kartu pelanggan berhasil dihapus');
    }
}
