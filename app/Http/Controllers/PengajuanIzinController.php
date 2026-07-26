<?php

namespace App\Http\Controllers;

use App\Models\PengajuanIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanIzinController extends Controller
{
    // Karyawan melihat pengajuan miliknya
    public function index()
    {
        $pengajuans = PengajuanIzin::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('izin.index', compact('pengajuans'));
    }

    // Form pengajuan
    public function create()
    {
        return view('izin.create');
    }

    // Simpan pengajuan
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required',
            'alasan' => 'required',
            'lampiran' => 'nullable|image|max:2048',
        ]);

        $lampiran = null;

        if ($request->hasFile('lampiran')) {
            $lampiran = $request->file('lampiran')
                ->store('izin', 'public');
        }

        PengajuanIzin::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'alasan' => $request->alasan,
            'lampiran' => $lampiran,
            'status' => 'Pending',
        ]);

        return redirect()
            ->route('izin.index')
            ->with('success', 'Pengajuan berhasil dikirim.');
    }

    // Halaman Admin
    public function admin()
    {
        $pengajuans = PengajuanIzin::with('user')
            ->latest()
            ->get();

        return view('izin.admin', compact('pengajuans'));
    }

    // Approve
    public function approve($id)
    {
        $izin = PengajuanIzin::findOrFail($id);

        $izin->update([
            'status' => 'Approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan disetujui.');
    }

    // Reject
    public function reject($id)
    {
        $izin = PengajuanIzin::findOrFail($id);

        $izin->update([
            'status' => 'Rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan ditolak.');
    }
}