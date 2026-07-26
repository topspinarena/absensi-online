@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">Approval Pengajuan Izin</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">

        <thead>

        <tr>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Alasan</th>
            <th>Status</th>
            <th width="180">Aksi</th>
        </tr>

        </thead>

        <tbody>

        @forelse($pengajuans as $izin)

            <tr>

                <td>{{ $izin->user->name }}</td>
                <td>{{ $izin->tanggal->format('d-m-Y') }}</td>
                <td>{{ $izin->jenis }}</td>
                <td>{{ $izin->alasan }}</td>

                <td>

                    @if($izin->status=='Pending')
                        <span class="badge bg-warning">Pending</span>

                    @elseif($izin->status=='Approved')
                        <span class="badge bg-success">Approved</span>

                    @else
                        <span class="badge bg-danger">Rejected</span>

                    @endif

                </td>

                <td>

                    @if($izin->status=='Pending')

                        <form action="{{ route('approval.approve',$izin->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn btn-success btn-sm">
                                Approve
                            </button>
                        </form>

                        <form action="{{ route('approval.reject',$izin->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn btn-danger btn-sm">
                                Reject
                            </button>
                        </form>

                    @endif

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="6" class="text-center">
                    Belum ada pengajuan.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection