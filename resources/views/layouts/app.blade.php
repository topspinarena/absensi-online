<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f5f7fb;
        }

        .navbar{
            background:#0d6efd;
        }

        .navbar-brand,
        .navbar-text,
        .nav-link{
            color:white !important;
        }

        .card{
            border:none;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,.08);
        }
    </style>

</head>
<body>

<nav class="navbar navbar-expand-lg">

<div class="container">

<a class="navbar-brand" href="/dashboard">
Absensi Online
</a>

<a href="{{ route('absensi.riwayat') }}" class="btn btn-info">
    Riwayat Absensi
</a>

<div class="ms-auto">

<a href="/dashboard" class="btn btn-light btn-sm">
Dashboard
</a>

<a href="/karyawan" class="btn btn-warning btn-sm">
Karyawan
</a>

<a href="/absensi" class="btn btn-success btn-sm">
Absensi
</a>

<a href="/setting-lokasi" class="btn btn-info btn-sm">
Lokasi GPS
</a>

<a href="/logout" class="btn btn-danger btn-sm">
Logout
</a>

</div>

</div>

</nav>

<div class="container mt-4">

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

@if(session('error'))

<div class="alert alert-danger">

{{ session('error') }}

</div>

@endif

<div class="card">

<div class="card-body">

@yield('content')

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>