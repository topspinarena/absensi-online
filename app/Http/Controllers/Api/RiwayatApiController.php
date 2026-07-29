<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;

class RiwayatApiController extends Controller
{
    public function index()
    {
        $riwayat = Absensi::where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $riwayat
        ]);
    }
}