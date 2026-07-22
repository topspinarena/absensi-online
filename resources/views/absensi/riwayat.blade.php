@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Riwayat Absensi</h2>

            <p class="text-muted mb-0">
                Laporan absensi karyawan
            </p>
        </div>

        <a href="{{ route('dashboard') }}"
           class="btn btn-secondary">

            Kembali ke Dashboard

        </a>

    </div>


    {{-- FILTER --}}

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('absensi.riwayat') }}">

                <div class="row g-3 align-items-end">

                    <div class="col-md-3">

                        <label class="form-label">
                            Tanggal Dari
                        </label>

                        <input
                            type="date"
                            name="tanggal_dari"
                            value="{{ $tanggalDari }}"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="col-md-3">

                        <label class="form-label">
                            Tanggal Sampai
                        </label>

                        <input
                            type="date"
                            name="tanggal_sampai"
                            value="{{ $tanggalSampai }}"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="col-md-3">

                        <label class="form-label">
                            Karyawan
                        </label>

                        <select
                            name="user_id"
                            class="form-control"
                        >

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


                    <div class="col-md-3">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            Tampilkan

                        </button>


                        <a
                            href="{{ route('absensi.riwayat') }}"
                            class="btn btn-secondary"
                        >

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- TABEL RIWAYAT --}}

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">

            <h5 class="mb-0">

                Data Absensi

                <span class="text-muted">

                    ({{ $riwayat->count() }} data)

                </span>

            </h5>

        </div>


        <div class="card-body">

            @if($riwayat->count() > 0)

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>No</th>

                                <th>Nama</th>

                                <th>Tanggal</th>

                                <th>Jam Masuk</th>

                                <th>Jam Pulang</th>

                                <th>Status</th>

                                <th>Jarak GPS</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($riwayat as $absen)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    <td>
                                        {{ $absen->user->name ?? '-' }}
                                    </td>


                                    <td>
                                        {{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}
                                    </td>


                                    <td>
                                        {{ $absen->jam_masuk ?? '-' }}
                                    </td>


                                    <td>
                                        {{ $absen->jam_keluar ?? '-' }}
                                    </td>


                                    <td>

                                        <span class="badge bg-success">

                                            {{ $absen->status }}

                                        </span>

                                    </td>


                                    <td>

                                        {{ $absen->jarak ?? '-' }}

                                        meter

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <h5>
                        Tidak ada data absensi
                    </h5>

                    <p class="text-muted">

                        Tidak ditemukan absensi pada periode tersebut.

                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection