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
    
    .payment-card {
        border: 1px solid #e3e8f0;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .payment-card:hover {
        transform: translateY(-5px);
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
        color: white;
        padding: 25px;
        border: none;
    }
    
    .card-header-custom h5 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .card-header-custom h5 i {
        margin-right: 10px;
    }
    
    .card-body-custom {
        padding: 30px;
    }
    
    .info-box {
        background-color: #f0f7ff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    
    .info-item:last-child {
        margin-bottom: 0;
    }
    
    .info-label {
        font-weight: 600;
        color: #374151;
    }
    
    .info-value {
        font-weight: 700;
        color: #1f2937;
    }
    
    .amount-value {
        font-size: 1.2rem;
        color: #10b981;
    }
    
    .section-title {
        font-size: 1.1rem;
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
    
    .payment-method {
        background-color: #f8fafc;
        border: 1px solid #e3e8f0;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    
    .payment-method:hover {
        background-color: #f0f7ff;
        border-color: #0066cc;
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(0, 102, 204, 0.1);
    }
    
    .payment-method-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .payment-method-image {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: cover;
        margin-right: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .no-image {
        width: 60px;
        height: 60px;
        background-color: #e0e7ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: #0066cc;
        font-size: 1.5rem;
    }
    
    .payment-method-info {
        flex-grow: 1;
    }
    
    .payment-method-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 5px;
    }
    
    .payment-number {
        font-family: monospace;
        font-size: 0.9rem;
        font-weight: 600;
        color: #0066cc;
        padding: 4px 8px;
        background-color: #e0e7ff;
        border-radius: 6px;
        display: inline-block;
    }
    
    .btn-select {
        background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-select:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 102, 204, 0.3);
        color: white;
    }
</style>


@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-credit-card me-3"></i>Pembayaran Tagihan
                    </h2>
                    <p class="mb-0 opacity-90">Pilih metode pembayaran untuk menyelesaikan tagihan</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-receipt me-1"></i>
                            {{ $tagihan->invoice_code }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="payment-card">
            <div class="card-body-custom">
                <!-- Invoice Informationkkkk -->
                <div class="info-box">
                    <div class="info-item"> 
                        <span class="info-label">
                            <i class="fas fa-file-invoice me-2"></i>
                            Nomor Invoice
                        </span>
                        <span class="info-value">{{ $tagihan->invoice_code }}</span>
                    </div>
                    <div class="info-item">
    <span class="info-label">
        <i class="fas fa-tag me-2"></i>
        Harga Paket
    </span>
    <span class="info-value">
        Rp {{ number_format($tagihan->paket->harga ?? 0,0,',','.') }}
    </span>
</div>

<div class="info-item">
    <span class="info-label">
        <i class="fas fa-tools me-2"></i>
        Biaya Pemasangan
    </span>
    <span class="info-value">
        Rp {{ number_format($tagihan->paket->biaya_pemasangan ?? 0,0,',','.') }}
    </span>
</div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-money-bill-wave me-2"></i>
                            Nominal Tagihan
                        </span>
                        <span class="info-value amount-value">Rp {{ number_format($tagihan->nominal,0,',','.') }}</span>
                    </div>
                </div>

                <!-- Payment Methods -->
                <h5 class="section-title">
                    <i class="fas fa-wallet"></i>
                    Pilih Metode Pembayaran
                </h5>

                @foreach ($metodePembayaran as $m)
                <div class="payment-method">
                    <!-- <form action="{{ route('pelanggan.tagihan.pilihmetode', $tagihan->id) }}"
                          method="POST">
                        @csrf
                        <input type="hidden" name="metode_pembayaran_id" value="{{ $m->id }}"> -->
                        
                        <div class="payment-method-header">
                            @if($m->icon)
                                <img src="{{ asset('storage/' . $m->icon) }}" 
                                     alt="{{ $m->nama_metode }}" 
                                     class="payment-method-image">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                            @endif
                            
                            <div class="payment-method-info">
                                <div class="payment-method-name">{{ $m->nama_metode }}</div>
                                <div class="payment-number">{{ $m->nomor_pembayaran }}</div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <a href="{{ route('pelanggan.tagihan.bulanan.upload', $tagihan->id) }}" class="btn-select">
    <i class="fas fa-check-circle me-2"></i>
    Gunakan Metode Ini
</a>

                        </div>
                    <!-- </form> -->
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection