@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="mb-4">
        Pengajuan Izin
    </h3>

    <form action="{{ route('izin.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="mb-3">

            <label>Tanggal</label>

            <input
                type="date"
                name="tanggal"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label>Jenis Pengajuan</label>

            <select
                name="jenis"
                class="form-control"
                required>

                <option value="">Pilih</option>

                <option value="Izin">Izin</option>

                <option value="Sakit">Sakit</option>

                <option value="Off">Off</option>

                <option value="Cuti">Cuti</option>

            </select>

        </div>

        <div class="mb-3">

            <label>Alasan</label>

            <textarea
                name="alasan"
                rows="5"
                class="form-control"
                required></textarea>

        </div>

        <div class="mb-3">

            <label>Lampiran (Opsional)</label>

            <input
                type="file"
                name="lampiran"
                class="form-control">

        </div>

        <button class="btn btn-primary">

            Kirim Pengajuan

        </button>

        <a href="{{ route('izin.index') }}"
           class="btn btn-secondary">

            Kembali

        </a>

    </form>

</div>

@endsection