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
    
    .schedule-card {
        border: 1px solid #e3e8f0;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .schedule-card:hover {
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
    
    .id-badge {
        background-color: #0066cc;
        color: white;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 0.875rem;
        font-weight: 600;
        font-family: monospace;
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
    
    .status-selesai {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .btn-outline-secondary {
        border-color: #6b7280;
        color: #6b7280;
    }
    
    .btn-outline-secondary:hover {
        background-color: #6b7280;
        border-color: #6b7280;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.2);
    }
    
    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: #6b7280;
    }
    
    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 16px;
        opacity: 0.6;
    }
    
    /* Pagination Styles */
    .pagination-container {
        padding: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .pagination {
        margin-bottom: 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .pagination .page-item {
        margin: 0 2px;
    }
    
    .pagination .page-item .page-link {
        color: #0066cc;
        border-color: #e3e8f0;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 0.875rem;
        min-width: 36px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 36px;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0066cc;
        border-color: #0066cc;
        color: white;
    }
    
    .pagination .page-item .page-link:hover {
        color: #0052a3;
        background-color: #f8fafc;
        border-color: #0066cc;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #fff;
        border-color: #dee2e6;
    }
    
    /* Menyembunyikan teks "Previous" dan "Next" dan mengganti dengan ikon */
    .pagination .page-item:first-child .page-link::before {
        content: "‹";
        font-weight: bold;
    }
    
    .pagination .page-item:last-child .page-link::before {
        content: "›";
        font-weight: bold;
    }
    
    .pagination .page-item:first-child .page-link span,
    .pagination .page-item:last-child .page-link span {
        display: none;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-history me-3"></i>Riwayat Instalasi
                    </h2>
                    <p class="mb-0 opacity-90">Daftar instalasi yang sudah diselesaikan</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-list me-1"></i>
                            {{ $riwayat->total() }} Riwayat
                        </span>
                        <a href="{{ route('teknisi.dashboard') }}" class="btn btn-outline-light ms-2">
                            <i class="fas fa-arrow-left me-1"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="schedule-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Pelanggan</th>
                            <th>Alamat</th>
                            <th>Paket</th>
                            <th>Tanggal Instalasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $item)
                        <tr>
                            <td>
                                <span class="id-badge">{{ $item->invoice_code }}</span>
                            </td>

                            <td>
                                @if ($item->pelanggan)
                                    <strong>{{ $item->pelanggan->nama ?? '-' }}</strong><br>
                                    <small class="text-muted">
                                        <i class="fas fa-phone me-1"></i>
                                        {{ $item->pelanggan->no_hp ?? '-' }}
                                    </small>
                                @else
                                    <span class="text-danger">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        Pelanggan tidak ditemukan
                                    </span>
                                @endif
                            </td>

                            <td>
                                <span class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $item->pelanggan->alamat ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-wifi me-1"></i>
                                    {{ $item->paket->nama_paket ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($item->jadwal_instalasi)->format('d M Y H:i') }}
                                </span>
                            </td>

                            <td>
                                <span class="status-badge status-selesai">
                                    <i class="fas fa-check-circle"></i>
                                    Selesai
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📋</div>
                                    <h5>Belum Ada Riwayat Instalasi</h5>
                                    <p>Instalasi yang telah selesai akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($riwayat->hasPages())
            <div class="pagination-container">
                {{ $riwayat->links('pagination::bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
</div>

@endsection