<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\SettingLokasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function riwayat(Request $request)
    {
        $tanggalDari = $request->tanggal_dari ?? now()->startOfMonth()->toDateString();
        $tanggalSampai = $request->tanggal_sampai ?? now()->toDateString();

        $query = Absensi::with('user')
            ->whereBetween('tanggal', [$tanggalDari, $tanggalSampai]);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $riwayat = $query
            ->orderBy('tanggal', 'DESC')
            ->orderBy('jam_masuk', 'DESC')
            ->get();

        $karyawan = User::where('role', 'karyawan')
            ->orderBy('name')
            ->get();

        return view('absensi.riwayat', compact(
            'riwayat',
            'karyawan',
            'tanggalDari',
            'tanggalSampai'
        ));
    }

    public function index()
{
    $absensi = Absensi::with('user')
        ->where('user_id', Auth::id())
        ->orderByDesc('tanggal')
        ->get();

    $lokasi = SettingLokasi::first();

    return view('absensi.index', compact(
        'absensi',
        'lokasi'
    ));
}

    public function masuk(Request $request)
    {
        $cek = Absensi::where('user_id', Auth::id())
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        if ($cek) {
            return back()->with('error', 'Anda sudah absen hari ini.');
        }

        $setting = SettingLokasi::first();

        if (!$setting) {
            return back()->with('error', 'Lokasi absensi belum diatur.');
        }

        $jarak = $this->hitungJarak(
            $setting->latitude,
            $setting->longitude,
            $request->latitude,
            $request->longitude
        );

        if ($jarak > $setting->radius) {
            return back()->with(
                'error',
                'Anda berada di luar radius absensi. Jarak Anda ' . round($jarak) . ' meter.'
            );
        }

        // Simpan foto selfie
        $namaFoto = null;

        if ($request->filled('foto')) {

            $image = $request->foto;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);

            $namaFoto = 'absen_' . time() . '.jpg';

            Storage::disk('public')->put(
                'absensi/' . $namaFoto,
                base64_decode($image)
            );
        }

        Absensi::create([
            'user_id'     => Auth::id(),
            'tanggal'     => now()->toDateString(),
            'jam_masuk'   => now()->format('H:i:s'),
            'status'      => 'Hadir',
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'jarak'       => round($jarak, 2),
            'foto'        => $namaFoto,
        ]);

        return back()->with('success', 'Absen masuk berhasil.');
    }

    public function keluar()
    {
        $absen = Absensi::where('user_id', Auth::id())
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        if (!$absen) {
            return back()->with('error', 'Belum absen masuk.');
        }

        $absen->update([
            'jam_keluar' => now()->format('H:i:s')
        ]);

        return back()->with('success', 'Absen pulang berhasil.');
    }

    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earth = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLon / 2) *
            sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earth * $c;
    }
}