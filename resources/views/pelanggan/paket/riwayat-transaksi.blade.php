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
    
    .transaction-card {
        border: 1px solid #e3e8f0;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .transaction-card:hover {
        transform: translateY(-5px);
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
        display: inline-flex;
        align-items: center;
    }
    
    .status-badge i {
        margin-right: 4px;
    }
    
    .status-menunggu {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .status-lunas {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-ditolak {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .date-badge {
        background-color: #f0f7ff;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.875rem;
        color: #0066cc;
        display: inline-flex;
        align-items: center;
    }
    
    .date-badge i {
        margin-right: 4px;
    }
    
    .amount-text {
        font-weight: 700;
        color: #10b981;
        font-size: 1rem;
    }
    
    .type-badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }
    
    .type-badge i {
        margin-right: 4px;
    }
    
    .type-awal {
        background-color: #e0e7ff;
        color: #3730a3;
    }
    
    .type-bulanan {
        background-color: #fef3c7;
        color: #92400e;
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
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-history me-3"></i>Riwayat Transaksi
                    </h2>
                    <p class="mb-0 opacity-90">Lihat semua riwayat transaksi pembayaran Anda</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-list me-1"></i>
                            {{ $transaksi->count() }} Transaksi
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="transaction-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="150">Tanggal</th>
                            <th width="120">Jenis</th>
                            <th>Total</th>
                            <th width="120">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $t)
                        <tr>
                            <td>
                                <span class="date-badge">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $t->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td>
                                @if($t->jenis == 'awal')
                                    <span class="type-badge type-awal">
                                        <i class="fas fa-plus-circle"></i>
                                        Awal
                                    </span>
                                @else
                                    <span class="type-badge type-bulanan">
                                        <i class="fas fa-sync-alt"></i>
                                        Bulanan
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="amount-text">
                                    Rp {{ number_format($t->total,0,',','.') }}
                                </span>
                            </td>
                            <td>
                                @if($t->status === 'menunggu')
                                    <span class="status-badge status-menunggu">
                                        <i class="fas fa-clock"></i>
                                        Menunggu
                                    </span>
                                @elseif($t->status === 'lunas')
                                    <span class="status-badge status-lunas">
                                        <i class="fas fa-check-circle"></i>
                                        Lunas
                                    </span>
                                @else
                                    <span class="status-badge status-ditolak">
                                        <i class="fas fa-times-circle"></i>
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📊</div>
                                    <h5>Belum Ada Transaksi</h5>
                                    <p>Anda belum memiliki riwayat transaksi</p>
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

@endsection