<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    // Menampilkan data karyawan
    public function index()
    {
        $karyawan = User::orderBy('id', 'ASC')->get();

        return view('karyawan.index', compact('karyawan'));
    }

    // Form tambah
    public function create()
    {
        return view('karyawan.create');
    }

    // Simpan data
    public function store(Request $request)
    {
        $request->validate([
    'name' => 'required',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|min:6',
]);

User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role' => 'karyawan',
]);
        return redirect('/karyawan')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    // Form edit
    public function edit($id)
    {
        $karyawan = User::findOrFail($id);

        return view('karyawan.edit', compact('karyawan'));
    }

    // Update data
    public function update(Request $request, $id)
{
    $karyawan = User::findOrFail($id);

    $request->validate([
    'name' => 'required',
    'email' => 'required|email|unique:users,email,' . $id,
    'role' => 'required|in:admin,karyawan',
]);

    $karyawan->name = $request->name;
$karyawan->email = $request->email;
$karyawan->role = $request->role;

    if (!empty($request->password)) {
        $karyawan->password = Hash::make($request->password);
    }

    $karyawan->save();

    return redirect()->route('karyawan.index')
        ->with('success', 'Data berhasil diupdate.');
}
    // Hapus data
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect('/karyawan')->with('success', 'Data berhasil dihapus.');
    }
}