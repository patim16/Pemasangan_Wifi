@extends('layout.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0 text-primary">Rekap Transaksi</h2>
        <div class="d-flex gap-2">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                <i class="bi bi-calendar-range me-1"></i> 
                Rentang Tanggal
            </span>
        </div>
    </div>

    {{-- FORM FILTER --}}
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('payment.rekap.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-semibold text-muted">Tanggal Mulai</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">
                            <i class="bi bi-calendar-date text-primary"></i>
                        </span>
                        <input type="date" name="start_date" value="{{ $start }}" class="form-control border-0 bg-light" required>
                    </div>
                </div>

                <div class="col-md-5">
                    <label class="form-label fw-semibold text-muted">Tanggal Akhir</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">
                            <i class="bi bi-calendar-date text-primary"></i>
                        </span>
                        <input type="date" name="end_date" value="{{ $end }}" class="form-control border-0 bg-light" required>
                    </div>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100 rounded-pill">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- HASIL --}}
    @if($start && $end)
        <div class="alert alert-info border-0 rounded-3 d-flex align-items-center mb-4">
            <i class="bi bi-info-circle-fill me-2"></i>
            <div>
                <strong>Rentang Waktu:</strong> {{ $start }} s/d {{ $end }}
            </div>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-4">
                {{-- Tombol Export --}}
                <div class="d-flex gap-2 justify-content-end mb-4">
                    {{-- Export PDF --}}
                    <a href="{{ route('payment.rekap.pdf', ['start_date' => $start, 'end_date' => $end]) }}"
                       class="btn btn-danger rounded-pill">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                    </a>

                    {{-- Export Excel --}}
                    <a href="{{ route('payment.rekap.excel', ['start_date' => $start, 'end_date' => $end]) }}"
                       class="btn btn-success rounded-pill">
                        <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                    </a>
                </div>

                {{-- Total Pendapatan --}}
                <div class="card bg-success bg-opacity-10 border-0 rounded-3 mb-4">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-cash-stack text-success fs-4"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0 text-success">Total Pendapatan</h5>
                                <div class="fw-bold fs-5">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-primary bg-opacity-10">
                            <tr>
                                <th class="border-0 px-4 py-3 text-muted fw-semibold">Pelanggan</th>
                                <th class="border-0 px-4 py-3 text-muted fw-semibold">Paket</th>
                                <th class="border-0 px-4 py-3 text-muted fw-semibold text-end">Total</th>
                                <th class="border-0 px-4 py-3 text-muted fw-semibold">Tanggal</th>
                                <th class="border-0 px-4 py-3 text-muted fw-semibold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $t)
                            <tr class="border-bottom border-light">
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-primary bg-opacity-10 rounded-circle me-3">
                                            <span class="text-primary fw-bold">{{ substr($t->pelanggan->nama, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $t->pelanggan->nama }}</div>
                                            <small class="text-muted d-none d-md-block">{{ $t->pelanggan->email ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-light border border-secondary-subtle text-dark px-3 py-2 rounded-pill">
                                        {{ $t->paket->nama }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <div class="fw-bold text-success">Rp {{ number_format($t->total, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar-date text-muted me-2"></i>
                                        <div>
                                            <div class="fw-semibold">{{ $t->created_at->format('d M') }}</div>
                                            <small class="text-muted">{{ $t->created_at->format('Y') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($t->status == 'terverifikasi')
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i> Terverifikasi
                                        </span>
                                    @elseif($t->status == 'menunggu')
                                        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">
                                            <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                        </span>
                                    @elseif($t->status == 'ditolak')
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                                            <i class="bi bi-x-circle me-1"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-calendar-x display-1 d-block mb-3"></i>
                                        <h5 class="fw-light">Tidak ada data transaksi pada rentang ini</h5>
                                        <p class="mb-0">Silakan pilih rentang tanggal lain untuk melihat rekap transaksi</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .avatar {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.03);
    }
    
    .badge {
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .input-group-text {
        border-right: none;
    }
    
    .form-control:focus {
        box-shadow: none;
        border-color: transparent;
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