<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiApiController extends Controller
{
    public function masuk(Request $request)
{
    $request->validate([
        'latitude' => 'required',
        'longitude' => 'required',
        'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $namaFoto = time() . '.' . $request->foto->extension();

    $request->foto->storeAs(
        'public/absensi',
        $namaFoto
    );

    $officeLat = -5.167001;
    $officeLng = 119.394241;
    $radius = 100;

    $jarak = $this->hitungJarak(
        $request->latitude,
        $request->longitude,
        $officeLat,
        $officeLng
    );

    if ($jarak > $radius) {

        return response()->json([
            'success' => false,
            'message' => 'Anda berada di luar area kantor.',
            'jarak' => $jarak
        ], 422);

    }

    $cek = Absensi::where('user_id', $request->user()->id)
        ->whereDate('tanggal', Carbon::today())
        ->first();

    if ($cek) {

        return response()->json([
            'success' => false,
            'message' => 'Anda sudah melakukan absen masuk.'
        ], 400);

    }

    $jamMasuk = Carbon::now('Asia/Makassar');

$batasTerlambat = Carbon::createFromTime(
    9,
    0,
    0,
    'Asia/Makassar'
);

$status = "Hadir";

if ($jamMasuk->greaterThan($batasTerlambat)) {
    $status = "Terlambat";
}

$absensi = Absensi::create([
    'user_id' => auth()->id(),
    'tanggal' => now(),
    'jam_masuk' => $jamMasuk->format('H:i:s'),
    'latitude' => $request->latitude,
    'longitude' => $request->longitude,
    'foto' => $namaFoto,
    'status' => $status,
]);

    return response()->json([
        'success' => true,
        'message' => 'Absen masuk berhasil.'
    ]);
}

    public function keluar(Request $request)
    {
        $absensi = Absensi::where('user_id', $request->user()->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        if (!$absensi) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan absen masuk.'
            ], 404);
        }

        if ($absensi->jam_keluar != null) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absen pulang.'
            ], 400);
        }

        $absensi->update([
            'jam_keluar' => Carbon::now()->format('H:i:s')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absen pulang berhasil.'
        ]);
    }

    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a =
            sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLon / 2) *
            sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}