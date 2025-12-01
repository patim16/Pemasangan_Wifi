@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h2 class="fw-bold mb-3">{{ $paket['nama'] }}</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="fw-bold">Harga: Rp {{ number_format($paket['harga'], 0, ',', '.') }} / bulan</h4>
            <p class="mt-3">{{ $paket['deskripsi'] }}</p>

            <a href="{{route('pelanggan.jadwal', request()->segment(3)) }}" class="btn btn-success mt-3">Pilih Jadwal Instalasi</a>

        </div>
    </div>

</div>
@endsection
