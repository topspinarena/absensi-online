@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Dashboard Administrator</h2>
            <p class="text-muted mb-0">
                Selamat datang, {{ Auth::user()->name }}
            </p>
        </div>

        <div>
            <span class="badge bg-dark">
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>


    {{-- STATISTIK --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Karyawan</p>
                    <h2>{{ $totalKaryawan }}</h2>
                    <small class="text-muted">
                        Karyawan terdaftar
                    </small>
                </div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted mb-1">Hadir Hari Ini</p>
                    <h2>{{ $hadirHariIni }}</h2>
                    <small class="text-success">
                        Sudah melakukan absensi
                    </small>
                </div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted mb-1">Belum Absen</p>
                    <h2>{{ $belumAbsen }}</h2>
                    <small class="text-danger">
                        Belum melakukan absensi
                    </small>
                </div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Absensi</p>
                    <h2>{{ $absensiHariIni->count() }}</h2>
                    <small class="text-primary">
                        Data hari ini
                    </small>
                </div>
            </div>
        </div>

    </div>


    {{-- FILTER ABSENSI --}}

<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <form method="GET" action="{{ route('dashboard') }}">

            <div class="row align-items-end g-3">

                <div class="col-md-4">

                    <label class="form-label">
                        Pilih Tanggal
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        value="{{ $tanggal }}"
                        class="form-control"
                    >

                </div>

                <div class="col-md-4">

                    <label class="form-label">
                        Pilih Karyawan
                    </label>

                    <select name="user_id" class="form-control">

                        <option value="">
                            Semua Karyawan
                        </option>

                        @foreach($karyawan as $user)

                            <option
                                value="{{ $user->id }}"
                                {{ request('user_id') == $user->id ? 'selected' : '' }}
                            >
                                {{ $user->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-4">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Tampilkan
                    </button>

                    <a
                        href="{{ route('dashboard') }}"
                        class="btn btn-secondary"
                    >
                        Reset
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>