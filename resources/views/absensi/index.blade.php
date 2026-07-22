@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Absensi Online</h2>
    <div class="alert alert-info">

    <strong>Status Lokasi :</strong>

    <span id="statusLokasi">
        Sedang mendeteksi lokasi...
    </span>

</div>

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

    <div class="row mb-3">

        <div class="col-md-6">

            <video id="video"
                   width="100%"
                   autoplay
                   playsinline
                   class="border rounded">
            </video>

            <canvas id="canvas" style="display:none;"></canvas>

        </div>

    </div>

    <div class="row">

    <div class="col-md-5">

        <div class="card">

            <div class="card-header bg-primary text-white">
                Kamera Selfie
            </div>

            <div class="card-body text-center">

                <video id="video"
                       autoplay
                       playsinline
                       width="100%"
                       style="border-radius:10px;border:1px solid #ccc">
                </video>

                <canvas id="canvas" style="display:none;"></canvas>

            </div>

        </div>

    </div>

    <div class="col-md-7">

        <div class="card">

            <div class="card-header bg-success text-white">
                Informasi Lokasi
            </div>

            <div class="card-body">

                <h5 id="statusLokasi">
                    Sedang mendeteksi lokasi...
                </h5>

                <h6>
                    Jarak :
                    <span id="jarak">
                        -
                    </span>
                </h6>

            </div>

        </div>

        <br>

        <form
            action="{{ route('absensi.masuk') }}"
            method="POST"
            id="formAbsen">

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
            action="{{ route('absensi.keluar') }}"
            method="POST">

            @csrf

            <button class="btn btn-danger btn-lg">

                🚪 Absen Pulang

            </button>

        </form>

    </div>

</div>

<hr>

    <table class="table table-bordered">

        <thead>
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Tanggal</th>
    <th>Masuk</th>
    <th>Pulang</th>
    <th>Status</th>
    <th>Foto Selfie</th>
    
    
</tr>
</thead>

        <tbody>

            @foreach($absensi as $row)

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
    <img src="{{ asset('storage/absensi/'.$row->foto) }}"
         width="80"
         class="img-thumbnail">
</a>

@else

Tidak ada

@endif

</td>

</tr>
            @endforeach

        </tbody>

    </table>

</div>
<script>

const kantorLat = {{ $lokasi->latitude ?? 0 }};
const kantorLng = {{ $lokasi->longitude ?? 0 }};
const radius = {{ $lokasi->radius ?? 0 }};

<script>

// =======================
// GPS
// =======================

if (navigator.geolocation) {

    navigator.geolocation.getCurrentPosition(function(position){

        let lat = position.coords.latitude;
        let lng = position.coords.longitude;

        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        let jarak = hitungJarak(
            kantorLat,
            kantorLng,
            lat,
            lng
        );

        if(jarak <= radius){

            document.getElementById('statusLokasi').innerHTML =
            "🟢 Di Dalam Radius ("+Math.round(jarak)+" meter)";

            document.querySelector('.btn-success').disabled = false;

        }else{

            document.getElementById('statusLokasi').innerHTML =
            "🔴 Di Luar Radius ("+Math.round(jarak)+" meter)";

            document.querySelector('.btn-success').disabled = true;

        }

    });

}

// =======================
// Kamera Depan
// =======================

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');

navigator.mediaDevices.getUserMedia({

    video:{
        facingMode:"user"
    }

}).then(function(stream){

    video.srcObject = stream;

}).catch(function(err){

    alert("Kamera tidak dapat diakses.");

});

// =======================
// Saat Submit
// =======================

document.getElementById('formAbsen').addEventListener('submit', function(){

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    canvas.getContext('2d').drawImage(
        video,
        0,
        0,
        canvas.width,
        canvas.height
    );

    document.getElementById('foto').value =
        canvas.toDataURL('image/jpeg');

});

</script>

<script>

const kantorLat={{ $lokasi->latitude }};
const kantorLng={{ $lokasi->longitude }};
const radius={{ $lokasi->radius }};

const video=document.getElementById('video');
const canvas=document.getElementById('canvas');

navigator.mediaDevices.getUserMedia({

video:{
facingMode:"user"
}

})
.then(function(stream){

video.srcObject=stream;

});

function hitungJarak(lat1,lon1,lat2,lon2){

let R=6371000;

let dLat=(lat2-lat1)*Math.PI/180;
let dLon=(lon2-lon1)*Math.PI/180;

let a=
Math.sin(dLat/2)*Math.sin(dLat/2)+
Math.cos(lat1*Math.PI/180)*
Math.cos(lat2*Math.PI/180)*
Math.sin(dLon/2)*
Math.sin(dLon/2);

let c=2*Math.atan2(Math.sqrt(a),Math.sqrt(1-a));

return R*c;

}

if(navigator.geolocation){

navigator.geolocation.getCurrentPosition(function(pos){

let lat=pos.coords.latitude;
let lng=pos.coords.longitude;

document.getElementById('latitude').value=lat;
document.getElementById('longitude').value=lng;

let jarak=hitungJarak(
kantorLat,
kantorLng,
lat,
lng
);

document.getElementById('jarak').innerHTML=
Math.round(jarak)+" Meter";

if(jarak<=radius){

document.getElementById('statusLokasi').innerHTML=
"🟢 Di Dalam Radius";

document.getElementById('btnMasuk').disabled=false;

}else{

document.getElementById('statusLokasi').innerHTML=
"🔴 Di Luar Radius";

document.getElementById('btnMasuk').disabled=true;

}

});

}

document
.getElementById('formAbsen')
.addEventListener('submit',function(){

canvas.width=video.videoWidth;
canvas.height=video.videoHeight;

canvas
.getContext('2d')
.drawImage(video,0,0);

document.getElementById('foto').value=
canvas.toDataURL('image/jpeg');

});

</script>
@endsection