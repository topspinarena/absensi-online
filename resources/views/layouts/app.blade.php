<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Absensi Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f5f7fb;
        }

        .navbar{
            background:#0d6efd;
        }

        .navbar-brand{
            color:#fff !important;
            font-weight:bold;
        }

        .card{
            border:none;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,.08);
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">

        <a class="navbar-brand" href="{{ route('dashboard') }}">
            Absensi Online
        </a>

        <div class="ms-auto">

            @auth

                @if(Auth::user()->role == 'admin')

                    <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                        Dashboard
                    </a>

                    <a href="{{ route('karyawan.index') }}" class="btn btn-warning btn-sm">
                        Karyawan
                    </a>

                    <a href="{{ route('setting-lokasi.index') }}" class="btn btn-info btn-sm">
                        Lokasi GPS
                    </a>

                    <a href="{{ route('absensi.riwayat') }}" class="btn btn-secondary btn-sm">
                        Riwayat
                    </a>

                @endif

                <a href="{{ route('absensi.index') }}" class="btn btn-success btn-sm">
                    Absensi
                </a>

                <a href="/logout" class="btn btn-danger btn-sm">
                    Logout
                </a>

            @endauth

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

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>