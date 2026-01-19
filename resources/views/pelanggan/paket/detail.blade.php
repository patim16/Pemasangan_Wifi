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
    
    .package-detail-card {
        border: 1px solid #e3e8f0;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .package-detail-card:hover {
        transform: translateY(-5px);
    }
    
    .package-detail-header {
        background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
        color: white;
        padding: 40px;
        text-align: center;
        position: relative;
    }
    
    .package-icon {
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2.5rem;
    }
    
    .package-detail-body {
        padding: 40px;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f8fafc;
        border-radius: 10px;
        transition: background-color 0.3s ease;
    }
    
    .info-item:hover {
        background-color: #f0f7ff;
    }
    
    .info-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 20px;
        flex-shrink: 0;
    }
    
    .info-content h5 {
        margin: 0;
        color: #374151;
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    .info-content p {
        margin: 5px 0 0 0;
        color: #1f2937;
        font-size: 1.1rem;
        font-weight: 700;
    }
    
    .description-box {
        background-color: #f0f7ff;
        border-left: 4px solid #0066cc;
        padding: 20px;
        border-radius: 8px;
        margin: 30px 0;
    }
    
    .description-box h5 {
        color: #0066cc;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .btn-schedule {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 10px;
        padding: 15px 30px;
        font-weight: 600;
        font-size: 1.1rem;
        color: white;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        width: 100%;
        text-align: center;
    }
    
    .btn-schedule:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .price-highlight {
        font-size: 2rem;
        font-weight: 700;
        color: #10b981;
    }
    
    .speed-badge {
        background-color: #e0e7ff;
        color: #3730a3;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-block;
        margin-top: 10px;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-wifi me-3"></i>{{ $paket->nama_paket }}
                    </h2>
                    <p class="mb-0 opacity-90">Detail informasi lengkap paket WiFi</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-star me-1"></i>
                            Paket Pilihan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="package-detail-card">
                    <div class="package-detail-header">
                        <div class="package-icon">
                            <i class="fas fa-wifi"></i>
                        </div>
                        <h2 class="mb-0">{{ $paket->nama_paket }}</h2>
                    </div>

                    <div class="package-detail-body">
                        <!-- Informasi Kecepatan -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            <div class="info-content">
                                <h5>Kecepatan Internet</h5>
                                <p>{{ $paket->kecepatan }} Mbps</p>
                            </div>
                        </div>

                        <!-- Informasi Harga -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div class="info-content">
                                <h5>Harga Berlangganan</h5>
                                <p class="price-highlight">Rp {{ number_format($paket->harga) }}</p>
                                <span class="speed-badge">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    per bulan
                                </span>
                            </div>
                        </div>

                        <!-- Biaya Pemasangan -->
<div class="info-item">
    <div class="info-icon">
        <i class="fas fa-tools"></i>
    </div>
    <div class="info-content">
        <h5>Biaya Pemasangan</h5>
        <p class="price-highlight">
            Rp {{ number_format($paket->biaya_pemasangan ?? 0,0,',','.') }}
        </p>
        <span class="speed-badge">
            <i class="fas fa-info-circle me-1"></i>
            Dibayar sekali di awal
        </span>
    </div>
</div>


                        <!-- Deskripsi Paket -->
                        @if($paket->deskripsi)
                        <div class="description-box">
                            <h5>
                                <i class="fas fa-info-circle me-2"></i>
                                Deskripsi Paket
                            </h5>
                            <p class="mb-0">{{ $paket->deskripsi }}</p>
                        </div>
                        @endif

                        <!-- Tombol Pilih Jadwal -->
                        <a href="{{ route('pelanggan.input-data', request()->segment(3)) }}" class="btn-schedule">
                            <i class="fas fa-calendar-check me-2"></i>
                            Pilih 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection