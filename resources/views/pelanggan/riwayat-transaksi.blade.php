@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold mb-3">Riwayat Transaksi</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Bukti</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transaksi as $t)
                        <tr>
                            <td>{{ $t->created_at }}</td>
                            <td>Rp {{ number_format($t->nominal) }}</td>
                            <td>{{ $t->metode ?? '-' }}</td>
                            <td>{{ ucfirst($t->status) }}</td>
                            <td>
                                @if($t->bukti)
                                    <a href="{{ asset('storage/'.$t->bukti) }}" target="_blank">Lihat</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
