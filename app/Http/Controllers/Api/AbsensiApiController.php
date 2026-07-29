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
        // Cek apakah hari ini sudah absen masuk
        $cek = Absensi::where('user_id', $request->user()->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        if ($cek) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absen masuk hari ini.'
            ], 400);
        }

        $absensi = Absensi::create([
            'user_id'     => $request->user()->id,
            'tanggal'     => Carbon::today(),
            'jam_masuk'   => Carbon::now()->format('H:i:s'),
            'status'      => 'Hadir',
            'latitude'    => null,
            'longitude'   => null,
            'foto'        => null,
            'jarak'       => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absen masuk berhasil.',
            'data'    => $absensi
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
}