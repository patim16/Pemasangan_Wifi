@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold">Kelola Pesanan WiFi</h3>

    <table class="table table-bordered table-hover mt-3">
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Paket</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>

        <tbody>
            @foreach($pesanan as $p)
                <tr>
                    <td>{{ $p->pelanggan->nama }}</td>
                    <td>{{ $p->paket->nama_paket }}</td>
                    <td>{{ $p->alamat }}</td>
                    <td>
                        <span class="badge bg-info">{{ ucfirst($p->status) }}</span>
                    </td>
                    <td>{{ $p->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
