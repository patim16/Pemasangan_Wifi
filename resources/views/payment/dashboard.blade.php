@extends('layout.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0 text-primary">Dashboard Payment</h2>
        <div class="d-flex gap-2">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                <i class="bi bi-clock-history me-1"></i> {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="avatar avatar-lg bg-primary bg-opacity-10 rounded-3">
                            <i class="bi bi-calendar-check text-primary fs-4"></i>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                            Hari Ini
                        </span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $totalHariIni }}</h3>
                    <p class="text-muted mb-0">Total Transaksi Hari Ini</p>
                    
                    @if($totalHariIni > 0)
                        @php
                            // Progress bar dinamis: setiap 5 transaksi = 25%
                            $progress = min(($totalHariIni / 5) * 25, 100);
                        @endphp
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-primary" role="progressbar" 
                                 style="width: {{ $progress }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">0</small>
                            <small class="text-muted">{{ $totalHariIni }}</small>
                        </div>
                    @else
                        <div class="text-center mt-3">
                            <span class="text-muted small fst-italic">Belum ada transaksi</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="avatar avatar-lg bg-warning bg-opacity-10 rounded-3">
                            <i class="bi bi-hourglass-split text-warning fs-4"></i>
                        </div>
                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">
                            Pending
                        </span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $menunggu }}</h3>
                    <p class="text-muted mb-0">Menunggu Verifikasi</p>
                    
                    @if($menunggu > 0)
                        @php
                            // Progress bar relatif terhadap total transaksi
                            $progress = $totalHariIni > 0 ? ($menunggu / $totalHariIni) * 100 : 0;
                        @endphp
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-warning" role="progressbar" 
                                 style="width: {{ $progress }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">0</small>
                            <small class="text-muted">{{ round($progress) }}%</small>
                        </div>
                    @else
                        <div class="text-center mt-3">
                            <span class="text-muted small fst-italic">Tidak ada yang menunggu</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="avatar avatar-lg bg-success bg-opacity-10 rounded-3">
                            <i class="bi bi-check-circle text-success fs-4"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                            Approved
                        </span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $valid }}</h3>
                    <p class="text-muted mb-0">Terverifikasi</p>
                    
                    @if($valid > 0)
                        @php
                            // Progress bar relatif terhadap total transaksi
                            $progress = $totalHariIni > 0 ? ($valid / $totalHariIni) * 100 : 0;
                        @endphp
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ $progress }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">0</small>
                            <small class="text-muted">{{ round($progress) }}%</small>
                        </div>
                    @else
                        <div class="text-center mt-3">
                            <span class="text-muted small fst-italic">Belum ada verifikasi</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="avatar avatar-lg bg-danger bg-opacity-10 rounded-3">
                            <i class="bi bi-x-circle text-danger fs-4"></i>
                        </div>
                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">
                            Rejected
                        </span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $invalid }}</h3>
                    <p class="text-muted mb-0">Ditolak</p>
                    
                    @if($invalid > 0)
                        @php
                            // Progress bar relatif terhadap total transaksi
                            $progress = $totalHariIni > 0 ? ($invalid / $totalHariIni) * 100 : 0;
                        @endphp
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-danger" role="progressbar" 
                                 style="width: {{ $progress }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">0</small>
                            <small class="text-muted">{{ round($progress) }}%</small>
                        </div>
                    @else
                        <div class="text-center mt-3">
                            <span class="text-muted small fst-italic">Tidak ada yang ditolak</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .avatar-lg {
        width: 56px;
        height: 56px;
    }
    
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .progress {
        background-color: rgba(0,0,0,0.05);
    }
    
    .badge {
        font-weight: 500;
        font-size: 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Animasi muncul untuk cards
        const cards = document.querySelectorAll('.row > div > .card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.5s ease';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50);
            }, index * 100);
        });
        
        // Animasi progress bar hanya jika ada
        setTimeout(() => {
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.transition = 'width 1.5s ease';
                    bar.style.width = width;
                }, 100);
            });
        }, 500);
    });
</script>
@endpush
@endsection