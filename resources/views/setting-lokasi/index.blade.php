@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">
        Pengaturan Lokasi Absensi
    </h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ url('/setting-lokasi') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label>Nama Lokasi</label>

            <input
                type="text"
                class="form-control"
                name="nama_lokasi"
                value="{{ $lokasi->nama_lokasi ?? '' }}"
                required>
        </div>

        <div class="mb-3">
            <label>Latitude</label>

            <input
                type="text"
                class="form-control"
                id="latitude"
                name="latitude"
                value="{{ $lokasi->latitude ?? '' }}"
                required>
        </div>

        <div class="mb-3">
            <label>Longitude</label>

            <input
                type="text"
                class="form-control"
                id="longitude"
                name="longitude"
                value="{{ $lokasi->longitude ?? '' }}"
                required>
        </div>

        <div class="mb-3">
            <label>Radius (Meter)</label>

            <input
                type="number"
                class="form-control"
                name="radius"
                value="{{ $lokasi->radius ?? 100 }}"
                required>
        </div>

        <button
            type="button"
            class="btn btn-info"
            onclick="ambilLokasi()">

            📍 Ambil Lokasi Saya

        </button>

        <button class="btn btn-primary">

            Simpan

        </button>

    </form>

</div>

<script>

function ambilLokasi(){

    if(navigator.geolocation){

        navigator.geolocation.getCurrentPosition(function(pos){

            document.getElementById('latitude').value=pos.coords.latitude;

            document.getElementById('longitude').value=pos.coords.longitude;

        });

    }else{

        alert("Browser tidak mendukung GPS");

    }

}

</script>

@endsection