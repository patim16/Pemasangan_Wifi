@extends('layout.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0 text-primary">Daftar Pembayaran Menunggu Verifikasi</h2>
        <div class="badge bg-warning text-dark p-2">
            <i class="bi bi-clock-history me-1"></i> {{ $data->count() }} Menunggu
        </div>
    </div>

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary bg-opacity-10">
                        <tr>
                            <th class="border-0 px-4 py-3 text-muted fw-semibold">#</th>
                            <th class="border-0 px-4 py-3 text-muted fw-semibold">Pelanggan</th>
                            <th class="border-0 px-4 py-3 text-muted fw-semibold">Paket</th>
                            <th class="border-0 px-4 py-3 text-muted fw-semibold text-end">Total</th>
                            <th class="border-0 px-4 py-3 text-muted fw-semibold text-center">Bukti</th>
                            <th class="border-0 px-4 py-3 text-muted fw-semibold text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $item)
                        <tr class="border-bottom border-light">
                            <td class="px-4 py-3">
                                <span class="badge bg-light text-dark rounded-pill">{{ $loop->iteration }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm bg-primary bg-opacity-10 rounded-circle me-3">
                                        <span class="text-primary fw-bold">{{ substr($item->pelanggan->nama ?? '-', 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $item->pelanggan->nama ?? '-' }}</div>
                                        <small class="text-muted d-none d-md-block">{{ $item->pelanggan->email ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-light border border-secondary-subtle text-dark px-3 py-2 rounded-pill">
                                    {{ $item->paket->nama ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="fw-bold text-success">Rp {{ number_format($item->total, 0, ',', '.') }}</div>
                                <small class="text-muted d-none d-lg-block">{{ $item->created_at->diffForHumans() }}</small>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ asset('uploads/bukti/' . $item->bukti) }}" 
                                   target="_blank"
                                   class="btn btn-sm btn-ghost-primary rounded-pill px-3">
                                    <i class="bi bi-image me-1"></i> Lihat
                                </a>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('payment.detail', $item->id) }}" 
                                   class="btn btn-sm btn-primary rounded-pill px-3">
                                    <i class="bi bi-arrow-right-circle me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox display-1 d-block mb-3"></i>
                                    <h5 class="fw-light">Tidak ada transaksi menunggu verifikasi</h5>
                                    <p class="mb-0">Semua pembayaran telah diverifikasi</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-ghost-primary {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border: 1px solid rgba(13, 110, 253, 0.2);
    }
    
    .btn-ghost-primary:hover {
        background-color: rgba(13, 110, 253, 0.2);
        color: #0a58ca;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.03);
    }
    
    .badge {
        font-weight: 500;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Animasi muncul untuk baris tabel
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            setTimeout(() => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(10px)';
                row.style.transition = 'all 0.3s ease';
                
                setTimeout(() => {
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, 50);
            }, index * 30);
        });
    });
</script>
@endpush
@endsection