@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Karyawan</h2>

        <a href="{{ route('karyawan.create') }}" class="btn btn-primary">
            Tambah Karyawan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">

        <thead class="table-dark">
            <tr>
                <th width="60">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th width="220">Aksi</th>
            </tr>
        </thead>

        <tbody>

        @forelse($karyawan as $item)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $item->name }}</td>

                <td>{{ $item->email }}</td>

                <td>{{ ucfirst($item->role) }}</td>

                <td>

                    <a href="{{ route('karyawan.edit',$item->id) }}"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('karyawan.destroy',$item->id) }}"
                          method="POST"
                          style="display:inline-block;">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus data ini?')">

                            Hapus

                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="5" class="text-center">
                    Belum ada data karyawan.
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection