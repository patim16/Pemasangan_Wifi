@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h2 class="fw-bold mb-3">Riwayat Pemesanan</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            @if($riwayat->isEmpty())
                <p class="text-muted">Belum ada pemesanan.</p>
            @else
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Invoice</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $item)
                        <tr>
                            <td>{{ $item->invoice_code }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ ucfirst($item->status) }}</td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>

</div>
@endsection
