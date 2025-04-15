<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // fungsi ini digunakan untuk menampilkan halaman utama
    public function index()
    {
        $users = User::all();
        return view('admin.petugasLoket.index', compact('users'));
    }

    // fungsi ini digunakan untuk menampilkan halaman tambah petugas
    public function create()
    {
        return view('admin.petugasLoket.create');
    }

    // fungsi ini digunakan untuk menyimpan data petugas baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,petugas',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        User::create($data);
        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    // fungsi ini digunakan untuk menampilkan halaman edit petugas
    public function show(User $user)
    {
        $users = User::all();
        return view('admin.petugasLoket.show', compact('user'));
    }

    // fungsi ini digunakan untuk menampilkan halaman edit petugas
    public function edit(User $user)
    {
        $users = User::all();
        return view('admin.petugasLoket.edit', compact('user'));
    }

    // fungsi ini digunakan untuk memperbarui data petugas
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'role' => 'required|in:admin,petugas',
        ]);

        $data = $request->all();
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    // fungsi ini digunakan untuk menghapus data petugas
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
