<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        \Log::info('Login dimulai');

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    \Log::info('Email: '.$request->email);

    if (Auth::attempt($credentials)) {

        \Log::info('Auth berhasil');

        $request->session()->regenerate();

        \Log::info('Session berhasil');

        if (Auth::user()->role == 'admin') {
            return redirect('/dashboard');
        }

        return redirect('/dashboard');
    }

    \Log::warning('Login gagal');

    return back()->withErrors([
        'email' => 'Email atau Password salah.',
    ]);
}
    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}