@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold mb-3">Pilih Paket WiFi</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="fw-bold">Paket 20 Mbps</h4>
                    <p>Rp 180.000 / bulan</p>
                    <a href="{{route('pelanggan.detailpaket', '20')}}" class="btn btn-primary">Lihat Detail</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="fw-bold">Paket 50 Mbps</h4>
                    <p>Rp 250.000 / bulan</p>
                    <a href="{{route('pelanggan.detailpaket', '50')}}" class="btn btn-primary">Lihat Detail</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
