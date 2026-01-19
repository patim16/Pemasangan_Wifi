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
    
    .history-card {
        border: 1px solid #e3e8f0;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .history-card:hover {
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
    
    .table {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table thead th {
        background-color: #f8fafc;
        border: none;
        font-weight: 600;
        color: #475569;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px;
    }
    
    .table tbody tr {
        transition: background-color 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: #f8fafc;
    }
    
    .table tbody td {
        padding: 16px;
        vertical-align: middle;
        border-top: 1px solid #f1f5f9;
        border-bottom: none;
        border-left: none;
        border-right: none;
    }
    
    .table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .status-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: capitalize;
        display: inline-flex;
        align-items: center;
    }
    
    .status-badge i {
        margin-right: 4px;
    }
    
    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .status-menunggu_survei {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .status-survei_selesai {
        background-color: #e0e7ff;
        color: #3730a3;
    }
    
    .status-menunggu_pembayaran {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .status-menunggu_verifikasi {
        background-color: #f3f4f6;
        color: #374151;
    }
    
    .status-lunas {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-siap_instalasi {
        background-color: #e0e7ff;
        color: #3730a3;
    }
    
    .status-selesai {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .invoice-code {
        font-family: monospace;
        background-color: #f0f7ff;
        padding: 4px 8px;
        border-radius: 6px;
        color: #0066cc;
        font-weight: 600;
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
    
    .date-badge {
        background-color: #f8fafc;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.875rem;
        color: #475569;
        display: inline-flex;
        align-items: center;
    }
    
    .date-badge i {
        margin-right: 4px;
        color: #0066cc;
    }
    
    .address-cell {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .notes-cell {
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-history me-3"></i>Riwayat Pemesanan
                    </h2>
                    <p class="mb-0 opacity-90">Lihat semua riwayat pemesanan Anda</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-list me-1"></i>
                            {{ $riwayat->count() }} Pemesanan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="history-card">
            <div class="card-header-custom">
                <h5>
                    <i class="fas fa-clipboard-list"></i>
                    Daftar Riwayat Pemesanan
                </h5>
            </div>

            <div class="card-body-custom">
                @if($riwayat->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">📋</div>
                        <h5>Belum Ada Pemesanan</h5>
                        <p>Anda belum melakukan pemesanan paket WiFi</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Alamat</th>
                                    <th>Patokan</th>
                                    <th>Catatan</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayat as $item)
                                <tr>
                                    <td>
                                        <span class="invoice-code">{{ $item->invoice_code }}</span>
                                    </td>
                                    <td class="address-cell" title="{{ $item->alamat }}">
                                        {{ $item->alamat }}
                                    </td>
                                    <td class="notes-cell" title="{{ $item->patokan ?? '-' }}">
                                        {{ $item->patokan ?? '-' }}
                                    </td>
                                    <td class="notes-cell" title="{{ $item->catatan ?? '-' }}">
                                        {{ $item->catatan ?? '-' }}
                                    </td>
                                    <td>
                                        @if($item->status == 'pending')
                                            <span class="status-badge status-pending">
                                                <i class="fas fa-clock"></i>
                                                Pending
                                            </span>
                                        @elseif($item->status == 'menunggu_survei')
                                            <span class="status-badge status-menunggu_survei">
                                                <i class="fas fa-search"></i>
                                                Menunggu Survei
                                            </span>
                                        @elseif($item->status == 'survei_selesai')
                                            <span class="status-badge status-survei_selesai">
                                                <i class="fas fa-check-circle"></i>
                                                Survei Selesai
                                            </span>
                                        @elseif($item->status == 'menunggu_pembayaran')
                                            <span class="status-badge status-menunggu_pembayaran">
                                                <i class="fas fa-money-bill-wave"></i>
                                                Menunggu Pembayaran
                                            </span>
                                        @elseif($item->status == 'menunggu_verifikasi')
                                            <span class="status-badge status-menunggu_verifikasi">
                                                <i class="fas fa-hourglass-half"></i>
                                                Menunggu Verifikasi
                                            </span>
                                        @elseif($item->status == 'lunas')
                                            <span class="status-badge status-lunas">
                                                <i class="fas fa-check-double"></i>
                                                Lunas
                                            </span>
                                        @elseif($item->status == 'siap_instalasi')
                                            <span class="status-badge status-siap_instalasi">
                                                <i class="fas fa-tools"></i>
                                                Siap Instalasi
                                            </span>
                                        @elseif($item->status == 'selesai')
                                            <span class="status-badge status-selesai">
                                                <i class="fas fa-check-circle"></i>
                                                Selesai
                                            </span>
                                        @else
                                            <span class="status-badge">
                                                <i class="fas fa-info-circle"></i>
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="date-badge">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ $item->created_at->format('d M Y') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection