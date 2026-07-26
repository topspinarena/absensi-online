<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">

<title>TOP SPIN ARENA</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Poppins,sans-serif;
}

body{

height:100vh;

display:flex;

justify-content:center;

align-items:center;

background:linear-gradient(135deg,#0d6efd,#4b8cff);

overflow:hidden;

}

.circle{

position:absolute;

border-radius:50%;

background:rgba(255,255,255,.15);

animation:float 8s infinite ease-in-out;

}

.circle:nth-child(1){

width:250px;
height:250px;
left:-70px;
top:-70px;

}

.circle:nth-child(2){

width:180px;
height:180px;
right:-50px;
bottom:-50px;

}

@keyframes float{

50%{

transform:translateY(-25px);

}

}

.login-card{

width:420px;

max-width:95%;

background:rgba(255,255,255,.15);

backdrop-filter:blur(20px);

padding:40px;

border-radius:25px;

box-shadow:0 15px 45px rgba(0,0,0,.25);

color:white;

}

.logo{

width:110px;

display:block;

margin:auto;

margin-bottom:15px;

}

h2{

font-weight:700;

text-align:center;

}

.subtitle{

text-align:center;

opacity:.9;

margin-bottom:30px;

}

.form-control{

border:none;

border-radius:12px;

padding:13px;

}

.form-control:focus{

box-shadow:none;

}

.btn-login{

width:100%;

padding:13px;

border-radius:12px;

font-weight:600;

font-size:18px;

}

.footer{

text-align:center;

margin-top:20px;

font-size:13px;

opacity:.9;

}

</style>

</head>

<body>

<div class="circle"></div>
<div class="circle"></div>

<div class="login-card">

<img src="{{ asset('images/topspin.png') }}" class="logo">

<h2>TOP SPIN ARENA</h2>

<div class="subtitle">

ABSENSI ONLINE

</div>

@if($errors->any())

<div class="alert alert-danger">

{{ $errors->first() }}

</div>

@endif

<form method="POST" action="/login">

@csrf

<div class="mb-3">

<input
type="email"
name="email"
class="form-control"
placeholder="Email"
required>

</div>

<div class="mb-4">

<input
type="password"
name="password"
class="form-control"
placeholder="Password"
required>

</div>

<button class="btn btn-warning btn-login">

LOGIN

</button>

</form>

<div class="footer">

© {{ date('Y') }} Top Spin Arena

</div>

</div>

</body>
</html>