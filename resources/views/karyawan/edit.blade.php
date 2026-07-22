@extends('layouts.app')

@section('content')

<div class="container mt-4">

<h2>Edit Karyawan</h2>

<form action="{{ route('karyawan.update',$karyawan->id) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">
<label>Nama</label>
<input type="text"
name="name"
value="{{ $karyawan->name }}"
class="form-control">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email"
name="email"
value="{{ $karyawan->email }}"
class="form-control">
</div>

<div class="mb-3">
    <label>Role</label>

    <select name="role" class="form-control">

        <option value="karyawan"
            {{ $karyawan->role == 'karyawan' ? 'selected' : '' }}>
            Karyawan
        </option>

        <option value="admin"
            {{ $karyawan->role == 'admin' ? 'selected' : '' }}>
            Administrator
        </option>

    </select>
</div>

<div class="mb-3">
<label>Password Baru (boleh kosong)</label>
<input type="password"
name="password"
class="form-control">
</div>

<button class="btn btn-primary">
Update
</button>

<a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

@endsection