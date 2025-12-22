@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    <h5 class="fw-bold mb-4">
        <i class="bi bi-receipt me-2"></i>Tagihan Awal Pelanggan
    </h5>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Invoice</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($pesanan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <strong>{{ $item->pelanggan->nama }}</strong><br>
                            <small class="text-muted">{{ $item->pelanggan->no_hp }}</small>
                        </td>

                        <td>
                            <span class="badge bg-secondary">
                                {{ $item->invoice_code }}
                            </span>
                        </td>

                        <td class="fw-bold text-success">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </td>

                        <td>
                            <span class="badge bg-warning">Menunggu Tagihan</span>
                        </td>

                        <td class="text-center">
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#modal{{ $item->id }}">
                                Kirim
                            </button>
                        </td>
                    </tr>

                    {{-- MODAL DETAIL --}}
                    <div class="modal fade" id="modal{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Tagihan</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p><b>Pelanggan:</b> {{ $item->pelanggan->nama }}</p>
                                    <p><b>Paket:</b> {{ $item->nama_paket }}</p>
                                    <p><b>Harga:</b> Rp {{ number_format($item->harga,0,',','.') }}</p>
                                    <p><b>Alamat:</b> {{ $item->alamat }}</p>
                                    <p><b>Laporan Teknisi:</b> {{ $item->laporan_teknisi }}</p>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                                    <form action="{{ route('payment.tagihan.awal.kirim', $item->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success">
                                            Kirim Tagihan
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
