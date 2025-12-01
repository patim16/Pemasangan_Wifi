@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h2 class="fw-bold mb-3">Invoice Pemesanan</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="fw-bold">Detail Instalasi</h5>

            <p><strong>Alamat:</strong> {{ session('input_data.alamat') }}</p>
            <p><strong>Patokan:</strong> {{ session('input_data.patokan') }}</p>
            <p><strong>Catatan:</strong> {{ session('input_data.catatan') }}</p>

            <p><strong>Latitude:</strong> {{ session('input_data.latitude') }}</p>
            <p><strong>Longitude:</strong> {{ session('input_data.longitude') }}</p>

            <hr>

            <form action="{{route ('pelanggan.konfirmasi', $paket_id)}}" method="POST">
            @csrf 
           <button class="btn btn-success">Konfirmasi Pemesanan</button>
        </form>

        </div>
    </div>

</div>
@endsection
