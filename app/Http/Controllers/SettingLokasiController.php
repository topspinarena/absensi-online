<?php

namespace App\Http\Controllers;

use App\Models\SettingLokasi;
use Illuminate\Http\Request;

class SettingLokasiController extends Controller
{
    public function index()
    {
        $lokasi = SettingLokasi::first();

        return view('setting-lokasi.index', compact('lokasi'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'radius' => 'required|numeric'
        ]);

        $lokasi = SettingLokasi::first();

        if ($lokasi) {
            $lokasi->update($request->all());
        } else {
            SettingLokasi::create($request->all());
        }

        return redirect()->back()->with('success', 'Lokasi berhasil disimpan.');
    }
}