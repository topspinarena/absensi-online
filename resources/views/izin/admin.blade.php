@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="mb-4">

        Approval Pengajuan

    </h3>

    <table class="table table-bordered">

        <thead>

        <tr>

            <th>Nama</th>

            <th>Tanggal</th>

            <th>Jenis</th>

            <th>Status</th>

            <th>Aksi</th>

        </tr>

        </thead>

        <tbody>

        @foreach($pengajuans as $izin)

            <tr>

                <td>{{ $izin->user->name }}</td>

                <td>{{ $izin->tanggal }}</td>

                <td>{{ $izin->jenis }}</td>

                <td>{{ $izin->status }}</td>

                <td>

                    @if($izin->status=="Pending")

                        <form
                            action="{{ route('izin.approve',$izin->id) }}"
                            method="POST"
                            style="display:inline">

                            @csrf

                            <button class="btn btn-success btn-sm">

                                Approve

                            </button>

                        </form>

                        <form
                            action="{{ route('izin.reject',$izin->id) }}"
                            method="POST"
                            style="display:inline">

                            @csrf

                            <button class="btn btn-danger btn-sm">

                                Reject

                            </button>

                        </form>

                    @endif

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection