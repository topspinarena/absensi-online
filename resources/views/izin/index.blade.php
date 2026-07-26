@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-3">

        <h3>Pengajuan Izin</h3>

        <a
            href="{{ route('izin.create') }}"
            class="btn btn-success">

            + Pengajuan Baru

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <table class="table table-bordered">

        <thead>

        <tr>

            <th>Tanggal</th>

            <th>Jenis</th>

            <th>Alasan</th>

            <th>Status</th>

        </tr>

        </thead>

        <tbody>

        @forelse($pengajuans as $izin)

            <tr>

                <td>{{ $izin->tanggal }}</td>

                <td>{{ $izin->jenis }}</td>

                <td>{{ $izin->alasan }}</td>

                <td>

                    @if($izin->status=="Pending")

                        <span class="badge bg-warning">

                            Pending

                        </span>

                    @elseif($izin->status=="Approved")

                        <span class="badge bg-success">

                            Approved

                        </span>

                    @else

                        <span class="badge bg-danger">

                            Rejected

                        </span>

                    @endif

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="4" class="text-center">

                    Belum ada pengajuan.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection