@extends('layout.app') 

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-receipt me-2"></i>Tagihan Awal Pelanggan
        </h5>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Invoice</th>
                            <th>Total Tagihan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($pesanan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $item->pelanggan->nama }}
                                </div>
                                <small class="text-muted">
                                    {{ $item->pelanggan->no_hp ?? '-' }}
                                </small>
                            </td>

                            <td>
                                <span class="badge bg-secondary">
                                    {{ $item->invoice_code }}
                                </span>
                            </td>

                            <td class="fw-bold text-success">
                                Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="badge bg-warning">
                                    Menunggu Tagihan
                                </span>
                            </td>

                            <td class="text-center">
                                <form action="{{ route('payment.tagihan.awal.kirim', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-primary btn-sm"
                                        onclick="return confirm('Kirim tagihan ke pelanggan?')">
                                        <i class="bi bi-send me-1"></i>
                                        Kirim Tagihan
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Tidak ada data tagihan awal
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
