@extends('layout.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0 text-primary">Rekap Transaksi</h2>
        <div class="d-flex gap-2">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                <i class="bi bi-{{ $mode == 'harian' ? 'calendar-day' : 'calendar-month' }} me-1"></i> 
                Mode {{ ucfirst($mode) }}
            </span>
        </div>
    </div>

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-body p-4">
            {{-- Pilihan Mode Rekap --}}
            <ul class="nav nav-tabs mb-4 border-0">
                <li class="nav-item">
                    <a class="nav-link {{ $mode == 'harian' ? 'active' : '' }} rounded-pill px-4" 
                       href="{{ route('payment.rekap.index', ['mode' => 'harian']) }}">
                        <i class="bi bi-calendar-day me-2"></i> Harian
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $mode == 'bulanan' ? 'active' : '' }} rounded-pill px-4" 
                       href="{{ route('payment.rekap.index', ['mode' => 'bulanan']) }}">
                        <i class="bi bi-calendar-month me-2"></i> Bulanan
                    </a>
                </li>
            </ul>

            {{-- =============== FORM HARIAN =============== --}}
            @if($mode == 'harian')
                <form method="GET" class="row g-3 mb-4">
                    <input type="hidden" name="mode" value="harian">
                    
                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-muted">Pilih Tanggal</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="bi bi-calendar-date text-primary"></i>
                            </span>
                            <input type="date" name="tanggal" class="form-control border-0 bg-light" value="{{ $tanggal }}">
                        </div>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100 rounded-pill">
                            <i class="bi bi-search me-1"></i> Tampilkan
                        </button>
                    </div>

                    @if($tanggal)
                        <div class="col-md-3 d-flex align-items-end">
                            <a href="{{ route('payment.rekap.pdf', ['mode' => 'harian', 'tanggal' => $tanggal]) }}" 
                               class="btn btn-danger w-100 rounded-pill">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                            </a>
                        </div>
                    @endif
                </form>
            @endif


            {{-- =============== FORM BULANAN =============== --}}
            @if($mode == 'bulanan')
                <form method="GET" class="row g-3 mb-4">
                    <input type="hidden" name="mode" value="bulanan">

                    <div class="col-md-5">
                        <label class="form-label fw-semibold text-muted">Pilih Bulan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="bi bi-calendar-event text-primary"></i>
                            </span>
                            <input type="month" name="bulan" class="form-control border-0 bg-light" value="{{ $bulan }}">
                        </div>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100 rounded-pill">
                            <i class="bi bi-search me-1"></i> Tampilkan
                        </button>
                    </div>

                    @if($bulan)
                        <div class="col-md-3 d-flex align-items-end">
                            <a href="{{ route('payment.rekap.pdf', ['mode' => 'bulanan', 'bulan' => $bulan]) }}" 
                               class="btn btn-danger w-100 rounded-pill">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                            </a>
                        </div>
                    @endif
                </form>
            @endif

            {{-- =============== HASIL REKAP =============== --}}
            @if(count($data) > 0)
                <div class="alert alert-info border-0 rounded-3 d-flex align-items-center mb-4">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <div>
                        <strong>Hasil Rekap</strong>  
                        @if($mode == 'harian')
                            Tanggal: <span class="fw-bold">{{ $tanggal }}</span>
                        @else
                            Bulan: <span class="fw-bold">{{ $bulan }}</span>
                        @endif
                    </div>
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

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-primary bg-opacity-10">
                            <tr>
                                <th class="border-0 px-4 py-3 text-muted fw-semibold">Pelanggan</th>
                                <th class="border-0 px-4 py-3 text-muted fw-semibold">Paket</th>
                                <th class="border-0 px-4 py-3 text-muted fw-semibold text-end">Total</th>
                                <th class="border-0 px-4 py-3 text-muted fw-semibold text-center">Status</th>
                                <th class="border-0 px-4 py-3 text-muted fw-semibold">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $t)
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
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $statusClass = match($t->status) {
                                            'terverifikasi' => 'bg-success bg-opacity-10 text-success',
                                            'ditolak' => 'bg-danger bg-opacity-10 text-danger',
                                            default => 'bg-info bg-opacity-10 text-info'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} px-3 py-2 rounded-pill">
                                        {{ $t->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-{{ $mode == 'harian' ? 'calendar-day' : 'calendar-month' }} text-muted me-2"></i>
                                        <div>
                                            <div class="fw-semibold">
                                                @if($mode == 'harian')
                                                    {{ $t->created_at->format('d M') }}
                                                @else
                                                    {{ $t->created_at->format('d M') }}
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ $t->created_at->format('Y') }}</small>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Summary Card --}}
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card bg-primary bg-opacity-10 border-0 rounded-3">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-clipboard-data text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 text-primary">Total Transaksi</h6>
                                        <div class="fw-bold">{{ $data->count() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info bg-opacity-10 border-0 rounded-3">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-graph-up text-info fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 text-info">Rata-rata</h6>
                                        <div class="fw-bold">Rp {{ number_format($data->avg('total'), 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning bg-opacity-10 border-0 rounded-3">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-star text-warning fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0 text-warning">Tertinggi</h6>
                                        <div class="fw-bold">Rp {{ number_format($data->max('total'), 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <div class="text-center py-5">
                    <div class="text-muted">
                        <i class="bi bi-{{ $mode == 'harian' ? 'calendar-x' : 'calendar2-x' }} display-1 d-block mb-3"></i>
                        <h5 class="fw-light">Tidak ada transaksi ditemukan</h5>
                        <p class="mb-0">Silakan pilih {{ $mode == 'harian' ? 'tanggal' : 'bulan' }} lain untuk melihat rekap transaksi</p>
                    </div>
                </div>
            @endif
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
    
    .nav-tabs .nav-link {
        border: none;
        color: var(--bs-secondary-color);
    }
    
    .nav-tabs .nav-link.active {
        background-color: rgba(13, 110, 253, 0.1);
        color: var(--bs-primary);
    }
    
    .nav-tabs .nav-link:hover {
        background-color: rgba(13, 110, 253, 0.05);
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
        
        // Animasi untuk summary cards
        const cards = document.querySelectorAll('.row > div > .card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.4s ease';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50);
            }, (rows.length * 30) + (index * 100));
        });
    });
</script>
@endpush
@endsection