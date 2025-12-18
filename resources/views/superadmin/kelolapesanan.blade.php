@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold">Kelola Pesanan WiFi</h3>

          <div class="card shadow-sm">
        <div class="card-body">

        <form action="{{ route('superadmin.kelolapesanan') }}" method="GET" class="mb-3">
    <div class="row g-2">
        <div class="col-md-4">
            <input 
                type="text" 
                name="search" 
                class="form-control"
                placeholder="Cari nama / email..."
                value="{{ request('search') }}"
            >
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">
                Cari
            </button>
        </div>
    </div>
</form>


    <table class="table table-bordered table-hover mt-3">
        <thead>
            <tr>
                 <th>No</th>
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
                     <td>{{ $loop->iteration }}</td>
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
