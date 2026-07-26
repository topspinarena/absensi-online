@extends('layouts.app')

@section('content')

<style>

.hero-card{

background:linear-gradient(135deg,#0d6efd,#4b8cff);

color:white;

border-radius:25px;

overflow:hidden;

}

.hero-card h2{

font-weight:700;

}

.stat-card{

border:none;

border-radius:20px;

transition:.3s;

}

.stat-card:hover{

transform:translateY(-5px);

box-shadow:0 15px 35px rgba(0,0,0,.12);

}

.stat-icon{

font-size:38px;

opacity:.85;

}

.table thead{

background:#0d6efd;

color:white;

}

</style>

<div class="hero-card shadow mb-4">

<div class="card-body p-5">

<div class="row align-items-center">

<div class="col-lg-8">

<h2>

👋 Selamat Datang,
{{ Auth::user()->name }}

</h2>

<p class="mb-0">

TOP SPIN ARENA - Sistem Absensi Online

</p>

</div>

<div class="col-lg-4 text-end">

<h3 id="jam"></h3>

<h5 id="tanggal"></h5>

</div>

</div>

</div>

</div>



<div class="row g-4 mb-4">

<div class="col-md-3">

<div class="card stat-card shadow">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<small>Total Karyawan</small>

<h2>{{ $totalKaryawan }}</h2>

</div>

<div class="stat-icon">

👥

</div>

</div>

</div>

</div>

</div>



<div class="col-md-3">

<div class="card stat-card shadow">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<small>Hadir Hari Ini</small>

<h2 class="text-success">

{{ $hadirHariIni }}

</h2>

</div>

<div class="stat-icon">

✅

</div>

</div>

</div>

</div>

</div>



<div class="col-md-3">

<div class="card stat-card shadow">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<small>Belum Absen</small>

<h2 class="text-danger">

{{ $belumAbsen }}

</h2>

</div>

<div class="stat-icon">

⏰

</div>

</div>

</div>

</div>

</div>



<div class="col-md-3">

<div class="card stat-card shadow">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<small>Total Absensi</small>

<h2>

{{ $absensiHariIni->count() }}

</h2>

</div>

<div class="stat-icon">

📋

</div>

</div>

</div>

</div>

</div>

</div>



<div class="card shadow border-0 mb-4">

<div class="card-body">

<form method="GET">

<div class="row g-3">

<div class="col-md-4">

<label>Tanggal</label>

<input
type="date"
name="tanggal"
value="{{ $tanggal }}"
class="form-control">

</div>

<div class="col-md-4">

<label>Karyawan</label>

<select
name="user_id"
class="form-control">

<option value="">

Semua Karyawan

</option>

@foreach($karyawan as $user)

<option
value="{{ $user->id }}"
{{ request('user_id')==$user->id?'selected':'' }}>

{{ $user->name }}

</option>

@endforeach

</select>

</div>

<div class="col-md-4 d-flex align-items-end">

<button class="btn btn-primary me-2">

Filter

</button>

<a
href="{{ route('dashboard') }}"
class="btn btn-secondary">

Reset

</a>

</div>

</div>

</form>

</div>

</div>



<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

Data Absensi

</div>

<div class="table-responsive">

<table class="table table-hover mb-0">

<thead>

<tr>

<th>No</th>

<th>Nama</th>

<th>Tanggal</th>

<th>Masuk</th>

<th>Pulang</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@forelse($absensiHariIni as $absen)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $absen->user->name }}</td>

<td>{{ $absen->tanggal }}</td>

<td>{{ $absen->jam_masuk ?? '-' }}</td>

<td>{{ $absen->jam_keluar ?? '-' }}</td>

<td>

@if($absen->status=='Hadir')

<span class="badge bg-success">

Hadir

</span>

@elseif($absen->status=='Izin')

<span class="badge bg-warning">

Izin

</span>

@elseif($absen->status=='Sakit')

<span class="badge bg-info">

Sakit

</span>

@else

<span class="badge bg-danger">

{{ $absen->status }}

</span>

@endif

</td>

</tr>

@empty

<tr>

<td colspan="6" class="text-center">

Belum ada data.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>



<script>

function waktu(){

const d=new Date();

document.getElementById("jam").innerHTML=d.toLocaleTimeString('id-ID');

document.getElementById("tanggal").innerHTML=d.toLocaleDateString('id-ID',{

weekday:'long',

day:'numeric',

month:'long',

year:'numeric'

});

}

setInterval(waktu,1000);

waktu();

</script>

@endsection