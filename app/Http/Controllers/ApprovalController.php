<?php

namespace App\Http\Controllers;

use App\Models\PengajuanIzin;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function index()
    {
        $pengajuans = PengajuanIzin::with('user')
            ->latest()
            ->get();

        return view('approval.index', compact('pengajuans'));
    }

    public function approve($id)
    {
        $izin = PengajuanIzin::findOrFail($id);

        $izin->update([
            'status' => 'Approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        Absensi::updateOrCreate(
            [
                'user_id' => $izin->user_id,
                'tanggal' => $izin->tanggal,
            ],
            [
                'status' => $izin->jenis,
                'jam_masuk' => null,
                'jam_keluar' => null,
                'latitude' => null,
                'longitude' => null,
                'jarak' => null,
                'foto' => null,
            ]
        );

        return redirect()->route('approval.index')
            ->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function reject($id)
    {
        $izin = PengajuanIzin::findOrFail($id);

        $izin->update([
            'status' => 'Rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('approval.index')
            ->with('success', 'Pengajuan berhasil ditolak.');
    }
}