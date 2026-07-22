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