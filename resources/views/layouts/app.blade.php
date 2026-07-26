<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <title>Absensi Online</title>

    <style>

body{
    font-family:'Poppins',sans-serif;
    background:#f5f7fb;
}

.navbar{
    background:linear-gradient(90deg,#2563eb,#1d4ed8);
    padding:12px 0;
    box-shadow:0 10px 25px rgba(0,0,0,.12);
}

.navbar-brand{
    color:#fff!important;
    font-weight:700;
}

.logo-text{
    line-height:1.1;
}

.logo-text small{
    font-size:11px;
    opacity:.9;
}

.card{
    border:none;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.btn{
    border-radius:12px;
    font-weight:600;
}

.alert{
    border-radius:15px;
}

.table{
    background:#fff;
    border-radius:15px;
    overflow:hidden;
}

/* =======================
   MOBILE
======================= */

@media(max-width:991px){

.navbar{
    padding:10px;
}

.navbar-brand img{
    width:40px;
}

.logo-text div{
    font-size:17px!important;
}

.logo-text small{
    font-size:10px;
}

#menu{
    background:white;
    margin-top:15px;
    border-radius:18px;
    padding:18px;
    box-shadow:0 15px 30px rgba(0,0,0,.15);
}

#menu .btn{
    width:100%;
    margin-bottom:10px;
}

.container{
    padding-left:14px;
    padding-right:14px;
}

.card{
    border-radius:20px;
}

.table{
    display:block;
    overflow-x:auto;
    white-space:nowrap;
}

}

/* =======================
   DESKTOP
======================= */

@media(min-width:992px){

#menu .btn{
    margin-left:4px;
}

}

</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container">

        <a class="navbar-brand d-flex align-items-center"
           href="{{ auth()->check() && auth()->user()->role == 'admin' ? route('dashboard') : route('absensi.index') }}">

            <img src="{{ asset('images/topspin.png') }}"
                 width="45"
                 class="me-3">

            <div class="logo-text">

                <div style="font-size:20px;font-weight:700;">
                    TOP SPIN ARENA
                </div>

                <small>ABSENSI ONLINE</small>

            </div>

        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="menu">

            <div class="ms-auto mt-3 mt-lg-0">

                @auth

                    @if(auth()->user()->role=='admin')

                        <a href="{{ route('dashboard') }}" class="btn btn-light me-2 mb-2">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>

                        <a href="{{ route('karyawan.index') }}" class="btn btn-warning me-2 mb-2">
                            <i class="bi bi-people-fill"></i> Karyawan
                        </a>

                        <a href="{{ route('setting-lokasi.index') }}" class="btn btn-info me-2 mb-2">
                            <i class="bi bi-geo-alt-fill"></i> Lokasi
                        </a>

                        <a href="{{ route('absensi.riwayat') }}" class="btn btn-secondary me-2 mb-2">
                            <i class="bi bi-clock-history"></i> Riwayat
                        </a>

                        <a href="{{ route('izin.index') }}" class="btn btn-primary me-2 mb-2">
                            <i class="bi bi-file-earmark-text"></i> Izin
                        </a>

                        <a href="{{ route('approval.index') }}" class="btn btn-dark me-2 mb-2">
                            <i class="bi bi-check-circle-fill"></i> Approval
                        </a>

                        <a href="{{ route('absensi.index') }}" class="btn btn-success me-2 mb-2">
                            <i class="bi bi-fingerprint"></i> Absensi
                        </a>

                    @else

                        <a href="{{ route('absensi.index') }}" class="btn btn-success me-2 mb-2">
                            <i class="bi bi-fingerprint"></i> Absensi
                        </a>

                        <a href="{{ route('izin.index') }}" class="btn btn-primary me-2 mb-2">
                            <i class="bi bi-file-earmark-text"></i> Pengajuan
                        </a>

                    @endif

                    <a href="/logout" class="btn btn-danger mb-2">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>

                @endauth

            </div>

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