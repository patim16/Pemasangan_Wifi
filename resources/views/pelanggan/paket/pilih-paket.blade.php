@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold mb-3">Pilih Paket WiFi</h2>

   <div class="row">
    @foreach($pakets as $paket)
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="fw-bold">{{ $paket->nama_paket }}</h4>
                <p>Rp {{ number_format($paket->harga) }} / bulan</p>

              <a href="{{ route('pelanggan.paket.detail', $paket->id) }}" class="btn btn-primary">Lihat Detail</a>

            </div>
        </div>
    </div>
    @endforeach
</div>


       
@endsection
