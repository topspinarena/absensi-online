@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-3">Absensi Online</h2>

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

    <div class="row">

        <div class="col-md-5">

            <div class="card">

                <div class="card-header bg-primary text-white">
                    Kamera Selfie
                </div>

                <div class="card-body text-center">

                    <video
                        id="video"
                        autoplay
                        playsinline
                        width="100%"
                        class="border rounded">
                    </video>

                    <canvas
                        id="canvas"
                        style="display:none;">
                    </canvas>

                </div>

            </div>

        </div>

        <div class="col-md-7">

            <div class="card">

                <div class="card-header bg-success text-white">
                    Status Lokasi
                </div>

                <div class="card-body">

                    <h5 id="statusLokasi">
                        Mendeteksi lokasi...
                    </h5>

                    <p>
                        <strong>Jarak :</strong>
                        <span id="jarak">-</span>
                    </p>

                </div>

            </div>

            <br>

            <form
                id="formAbsen"
                method="POST"
                action="{{ route('absensi.masuk') }}">

                @csrf

                <input
                    type="hidden"
                    name="latitude"
                    id="latitude">

                <input
                    type="hidden"
                    name="longitude"
                    id="longitude">

                <input
                    type="hidden"
                    name="foto"
                    id="foto">

                <button
                    id="btnMasuk"
                    class="btn btn-success btn-lg"
                    disabled>

                    📍 Absen Masuk

                </button>

            </form>

            <br>

            <form
                method="POST"
                action="{{ route('absensi.keluar') }}">

                @csrf

                <button class="btn btn-danger btn-lg">

                    🚪 Absen Pulang

                </button>

            </form>

        </div>

    </div>

    <hr>

    <table class="table table-bordered table-striped">

        <thead>

        <tr>

            <th>No</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Masuk</th>
            <th>Pulang</th>
            <th>Status</th>
            <th>Foto</th>

        </tr>

        </thead>

        <tbody>

        @forelse($absensi as $row)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $row->user->name }}</td>

                <td>{{ $row->tanggal }}</td>

                <td>{{ $row->jam_masuk }}</td>

                <td>{{ $row->jam_keluar }}</td>

                <td>{{ $row->status }}</td>

                <td>

                    @if($row->foto)

                        <a href="{{ asset('storage/absensi/'.$row->foto) }}" target="_blank">

                            <img
                                src="{{ asset('storage/absensi/'.$row->foto) }}"
                                width="80"
                                class="img-thumbnail">

                        </a>

                    @else

                        -

                    @endif

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="7" class="text-center">
                    Belum ada data absensi
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

<script>

const kantorLat={{ $lokasi->latitude ?? 0 }};
const kantorLng={{ $lokasi->longitude ?? 0 }};
const radius={{ $lokasi->radius ?? 0 }};

const video=document.getElementById('video');
const canvas=document.getElementById('canvas');
const btn=document.getElementById('btnMasuk');

navigator.mediaDevices.getUserMedia({

    video:{
        facingMode:"user"
    }

})
.then(stream=>{

    video.srcObject=stream;

})
.catch(()=>{

    alert("Kamera tidak dapat diakses.");

});

function hitungJarak(lat1,lon1,lat2,lon2){

    const R=6371000;

    const dLat=(lat2-lat1)*Math.PI/180;
    const dLon=(lon2-lon1)*Math.PI/180;

    const a=
        Math.sin(dLat/2)**2+
        Math.cos(lat1*Math.PI/180)*
        Math.cos(lat2*Math.PI/180)*
        Math.sin(dLon/2)**2;

    const c=2*Math.atan2(Math.sqrt(a),Math.sqrt(1-a));

    return R*c;

}

function updateLokasi(pos){

    const lat=pos.coords.latitude;
    const lng=pos.coords.longitude;
    const acc=pos.coords.accuracy;

    document.getElementById("latitude").value=lat;
    document.getElementById("longitude").value=lng;

    const jarak=hitungJarak(
        kantorLat,
        kantorLng,
        lat,
        lng
    );

    document.getElementById("jarak").innerHTML=
        Math.round(jarak)+" Meter | Akurasi ±"+Math.round(acc)+" Meter";

    if(acc>30){

        document.getElementById("statusLokasi").innerHTML=
        "🟡 Menunggu GPS lebih akurat...";

        btn.disabled=true;

        return;

    }

    if(jarak<=radius){

        document.getElementById("statusLokasi").innerHTML=
        "🟢 Anda berada di dalam radius";

        btn.disabled=false;

    }else{

        document.getElementById("statusLokasi").innerHTML=
        "🔴 Anda berada di luar radius";

        btn.disabled=true;

    }

}

function gagalLokasi(){

    alert("GPS tidak dapat diakses. Aktifkan Lokasi Presisi.");

}

navigator.geolocation.watchPosition(

    updateLokasi,

    gagalLokasi,

    {

        enableHighAccuracy:true,
        timeout:20000,
        maximumAge:0

    }

);

document.getElementById("formAbsen").addEventListener("submit",function(){

    canvas.width=video.videoWidth;
    canvas.height=video.videoHeight;

    canvas.getContext("2d").drawImage(
        video,
        0,
        0,
        canvas.width,
        canvas.height
    );

    document.getElementById("foto").value=
        canvas.toDataURL("image/jpeg",0.8);

});

</script>

@endsection