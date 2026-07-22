<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();

        $karyawan = User::where('role', 'karyawan')
            ->orderBy('name')
            ->get();

        $totalKaryawan = $karyawan->count();

        $query = Absensi::with('user')
            ->whereDate('tanggal', $tanggal);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $absensiHariIni = $query
            ->orderBy('jam_masuk', 'DESC')
            ->get();

        $hadirHariIni = $absensiHariIni->count();

        $belumAbsen = $totalKaryawan - $hadirHariIni;

        return view('dashboard', compact(
            'totalKaryawan',
            'hadirHariIni',
            'belumAbsen',
            'absensiHariIni',
            'tanggal',
            'karyawan'
        ));
    }
}