@extends('layout.app')

@section('content')
<style>
    /* Clean Blue Theme - Same as Other Pages */
    .page-header {
        background-color: #0066cc;
        color: white;
        padding: 2.5rem 0;
        margin-bottom: 2rem;
    }
    
    .package-card {
        border: 1px solid #e3e8f0;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
        height: 100%;
    }
    
    .package-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 102, 204, 0.15);
        border-color: #0066cc;
    }
    
    .package-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid #e3e8f0;
    }
    
    .package-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        color: white;
        font-size: 1.5rem;
    }
    
    .package-body {
        padding: 25px;
        text-align: center;
    }
    
    .package-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 10px;
    }
    
    .package-price {
        font-size: 1.5rem;
        font-weight: 600;
        color: #0066cc;
        margin-bottom: 20px;
    }
    
    .package-price small {
        font-size: 0.9rem;
        color: #6b7280;
        font-weight: 400;
    }
    
    .btn-detail {
        background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 102, 204, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: #6b7280;
    }
    
    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.6;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-wifi me-3"></i>Pilih Paket WiFi
                    </h2>
                    <p class="mb-0 opacity-90">Temukan paket yang sesuai dengan kebutuhan Anda</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-box me-1"></i>
                            {{ $pakets->count() }} Paket Tersedia
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            @forelse($pakets as $paket)
            <div class="col-md-4 mb-4">
                <div class="package-card">
                    <div class="package-header">
                        <div class="package-icon">
                            <i class="fas fa-wifi"></i>
                        </div>
                    </div>
                    <div class="package-body">
                        <h4 class="package-name">{{ $paket->nama_paket }}</h4>
                        <div class="package-price">
                            Rp {{ number_format($paket->harga) }}
                            <small>/ bulan</small>
                        </div>
                        
                        @if($paket->kecepatan)
                            <div class="mb-3">
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-tachometer-alt me-1"></i>
                                    {{ $paket->kecepatan }} Mbps
                                </span>
                            </div>
                        @endif
                        
                        @if($paket->deskripsi)
                            <p class="text-muted small mb-3">{{ $paket->deskripsi }}</p>
                        @endif

                        <a href="{{ route('pelanggan.paket.detail', $paket->id) }}" class="btn-detail">
                            <i class="fas fa-info-circle me-2"></i>Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-state-icon">📦</div>
                    <h4>Belum Ada Paket</h4>
                    <p>Maaf, paket WiFi belum tersedia saat ini.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection