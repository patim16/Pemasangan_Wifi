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
    
    .invoice-card {
        border: 1px solid #e3e8f0;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .invoice-card:hover {
        transform: translateY(-5px);
    }
    
    .invoice-header {
        background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
        color: white;
        padding: 30px;
        text-align: center;
    }
    
    .invoice-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2rem;
    }
    
    .invoice-body {
        padding: 40px;
    }
    
    .section-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 10px;
        color: #0066cc;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .info-item {
        background-color: #f8fafc;
        padding: 20px;
        border-radius: 12px;
        border-left: 4px solid #0066cc;
        transition: background-color 0.3s ease;
    }
    
    .info-item:hover {
        background-color: #f0f7ff;
    }
    
    .info-label {
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 5px;
        font-weight: 600;
    }
    
    .info-value {
        font-size: 1.1rem;
        color: #1f2937;
        font-weight: 500;
    }
    
    .status-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        text-transform: capitalize;
        display: inline-flex;
        align-items: center;
    }
    
    .status-badge i {
        margin-right: 6px;
    }
    
    .btn-invoice {
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-back {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        border: none;
        color: white;
    }
    
    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(107, 114, 128, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .btn-confirm {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        color: white;
    }
    
    .btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        color: white;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        border: 1px solid #fecaca;
        color: #991b1b;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
    }
    
    .alert-danger i {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
    }
    
    .coordinates-info {
        background-color: #f0f7ff;
        border-radius: 8px;
        padding: 15px;
        margin-top: 15px;
    }
    
    .coordinates-info h6 {
        color: #0066cc;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .coordinate-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }
    
    .coordinate-item span:first-child {
        font-weight: 600;
        color: #374151;
    }
    
    .coordinate-item span:last-child {
        color: #0066cc;
        font-family: monospace;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-file-invoice me-3"></i>Invoice Pemesanan
                    </h2>
                    <p class="mb-0 opacity-90">Detail informasi pemesanan dan instalasi</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        @if(isset($pesanan))
                            <span class="badge bg-white text-blue px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i>
                                Pesanan Dibuat
                            </span>
                        @else
                            <span class="badge bg-white text-blue px-3 py-2">
                                <i class="fas fa-eye me-1"></i>
                                Preview Invoice
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="invoice-card">
                    <div class="invoice-header">
                        <div class="invoice-icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <h3 class="mb-0">Invoice Pemesanan</h3>
                        <p class="mb-0 opacity-90">WiFi Management System</p>
                    </div>

                    <div class="invoice-body">
                        @if(isset($pesanan))
                            {{-- =========================
                                INVOICE SETELAH ADA PESANAN
                            ========================== --}}
                            <div class="section-title">
                                <i class="fas fa-shopping-cart"></i>
                                Detail Pemesanan
                            </div>

                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-user me-2"></i>Nama Pelanggan
                                    </div>
                                    <div class="info-value">
                                        {{ $pesanan->pelanggan->nama ?? '-' }}
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-wifi me-2"></i>Paket Layanan
                                    </div>
                                    <div class="info-value">
                                        {{ $pesanan->paket->nama_paket ?? '-' }}
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-info-circle me-2"></i>Status Pesanan
                                    </div>
                                    <div class="info-value">
                                        <span class="status-badge bg-success">
                                            <i class="fas fa-check-circle"></i>
                                            {{ ucfirst(str_replace('_',' ',$pesanan->status)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="section-title">
                                <i class="fas fa-tools"></i>
                                Detail Instalasi
                            </div>

                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-home me-2"></i>Alamat
                                    </div>
                                    <div class="info-value">
                                        {{ $pesanan->alamat }}
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-flag me-2"></i>Patokan
                                    </div>
                                    <div class="info-value">
                                        {{ $pesanan->patokan ?? 'Tidak ada' }}
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-sticky-note me-2"></i>Catatan
                                    </div>
                                    <div class="info-value">
                                        {{ $pesanan->catatan ?? 'Tidak ada' }}
                                    </div>
                                </div>
                            </div>

                            <div class="coordinates-info">
                                <h6>
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    Koordinat Lokasi
                                </h6>
                                <div class="coordinate-item">
                                    <span>Latitude:</span>
                                    <span>{{ $pesanan->latitude }}</span>
                                </div>
                                <div class="coordinate-item">
                                    <span>Longitude:</span>
                                    <span>{{ $pesanan->longitude }}</span>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('pelanggan.tagihan') }}" class="btn-invoice btn-back">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali ke Tagihan
                                </a>
                            </div>

                        @else
                            {{-- =========================
                                INVOICE PREVIEW (BELUM ADA PESANAN)
                            ========================== --}}
                            @php
                                $data = session('input_data');
                            @endphp

                            @if(!$data)
                                <div class="alert-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Data Tidak Ditemukan</strong>
                                    <p class="mb-0 mt-2">Data pemesanan tidak tersedia. Silakan ulangi proses pemesanan.</p>
                                </div>
                            @else
                                <div class="section-title">
                                    <i class="fas fa-eye"></i>
                                    Preview Pemesanan
                                </div>

                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-home me-2"></i>Alamat
                                        </div>
                                        <div class="info-value">
                                            {{ $data['alamat'] }}
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-flag me-2"></i>Patokan
                                        </div>
                                        <div class="info-value">
                                            {{ $data['patokan'] ?? 'Tidak ada' }}
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-sticky-note me-2"></i>Catatan
                                        </div>
                                        <div class="info-value">
                                            {{ $data['catatan'] ?? 'Tidak ada' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="coordinates-info">
                                    <h6>
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        Koordinat Lokasi
                                    </h6>
                                    <div class="coordinate-item">
                                        <span>Latitude:</span>
                                        <span>{{ $data['latitude'] }}</span>
                                    </div>
                                    <div class="coordinate-item">
                                        <span>Longitude:</span>
                                        <span>{{ $data['longitude'] }}</span>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <form action="{{ route('pelanggan.konfirmasi', request()->route('paket_id')) }}"
                                          method="POST"
                                          style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-invoice btn-confirm">
                                            <i class="fas fa-check me-2"></i>
                                            Konfirmasi Pemesanan
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection