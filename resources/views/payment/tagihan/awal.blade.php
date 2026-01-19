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
    
    .bill-card {
        border: 1px solid #e3e8f0;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .bill-card:hover {
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
    
    .invoice-badge {
        background-color: #f0f7ff;
        color: #0066cc;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-family: monospace;
        font-size: 0.875rem;
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
    
    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .amount-text {
        font-size: 1.1rem;
        font-weight: 700;
        color: #10b981;
    }
    
    .btn-action {
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }
    
    .btn-primary {
        background-color: #0066cc;
        border-color: #0066cc;
    }
    
    .btn-primary:hover {
        background-color: #0052a3;
        border-color: #0052a3;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 102, 204, 0.2);
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
    
    .modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    .modal-header {
        background-color: #0066cc;
        color: white;
        border-radius: 12px 12px 0 0;
        border: none;
    }
    
    .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
    }
    
    .modal-footer {
        background-color: #f8fafc;
        border-top: none;
    }
    
    .info-item {
        margin-bottom: 15px;
    }
    
    .info-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 5px;
    }
    
    .info-value {
        color: #1f2937;
    }
    
    .coordinates-box {
        background-color: #f0f7ff;
        border-radius: 8px;
        padding: 15px;
        margin-top: 15px;
    }
    
    .coordinates-box h6 {
        color: #0066cc;
        margin-bottom: 10px;
        font-weight: 600;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-file-invoice-dollar me-3"></i>Tagihan Awal Pelanggan
                    </h2>
                    <p class="mb-0 opacity-90">Kelola tagihan awal untuk pelanggan baru</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-list me-1"></i>
                            {{ $pesanan->count() }} Tagihan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Alert Notification -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Bill Table -->
        <div class="bill-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Pelanggan</th>
                            <th>Invoice</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan as $item)
                        <tr>
                            <td>
                                <span class="badge bg-primary rounded-pill">{{ $loop->iteration }}</span>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        {{ substr(strtoupper($item->pelanggan->nama), 0, 1) }}
                                    </div>
                                    <div>
                                        <strong>{{ $item->pelanggan->nama }}</strong><br>
                                        <small class="text-muted">
                                            <i class="fas fa-phone me-1"></i>
                                            {{ $item->pelanggan->no_hp }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="invoice-badge">{{ $item->invoice_code }}</span>
                            </td>

                         <td>
    @php
        $total =
            ($item->paket->harga ?? 0)
          + ($item->paket->biaya_pemasangan ?? 0);
    @endphp

    <div class="amount-text">
        Rp {{ number_format($total, 0, ',', '.') }}
    </div>

    <small class="text-muted">
        Paket + Biaya Pasang
    </small>
</td>



                            <td>
                                <span class="status-badge status-pending">
                                    <i class="fas fa-clock"></i>
                                    Menunggu Tagihan
                                </span>
                            </td>

                            <td class="text-center">
                                <button class="btn btn-sm btn-primary btn-action"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal{{ $item->id }}"
                                    title="Kirim Tagihan">
                                    <i class="fas fa-paper-plane me-1"></i>
                                    Kirim
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📄</div>
                                    <h5>Tidak Ada Tagihan</h5>
                                    <p>Belum ada tagihan yang perlu dikirim</p>
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

{{-- ================= MODAL DETAIL - DIPINDAH KE LUAR TABEL ================= --}}
@foreach ($pesanan as $item)
<div class="modal fade" id="modal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-file-invoice me-2"></i>
                    Detail Tagihan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-user me-2"></i>Pelanggan
                            </div>
                            <div class="info-value fw-semibold">{{ $item->pelanggan->nama }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-wifi me-2"></i>Paket
                            </div>
                            <div class="info-value">{{ $item->paket->nama_paket }}</div>
                        </div>

                        <div class="info-item">
    <div class="info-label">
        <i class="fas fa-tag me-2"></i>Harga Paket
    </div>
    <div class="info-value">
        Rp {{ number_format($item->paket->harga ?? 0, 0, ',', '.') }}
    </div>
</div>

<div class="info-item">
    <div class="info-label">
        <i class="fas fa-tools me-2"></i>Biaya Pemasangan
    </div>
    <div class="info-value">
        Rp {{ number_format($item->paket->biaya_pemasangan ?? 0, 0, ',', '.') }}
    </div>
</div>

<hr>

                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-money-bill-wave me-2"></i>Total Bayar
                            </div>
                           @php
    $total =
        ($item->paket->harga ?? 0)
      + ($item->paket->biaya_pemasangan ?? 0);
@endphp

<div class="info-value amount-text">
    Rp {{ number_format($total, 0, ',', '.') }}
</div>

                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-home me-2"></i>Alamat
                            </div>
                            <div class="info-value">{{ $item->alamat }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-clipboard-check me-2"></i>Laporan Teknisi
                            </div>
                            <div class="info-value">{{ $item->laporan_teknisi ?? 'Belum ada laporan' }}</div>
                        </div>
                    </div>
                </div>

                <div class="coordinates-box">
                    <h6>
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Koordinat Lokasi
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-0"><strong>Latitude:</strong> {{ $item->latitude ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0"><strong>Longitude:</strong> {{ $item->longitude ?? '-' }}</p>
                        </div>
                    </div>

                    @if($item->latitude && $item->longitude)
                        <div class="mt-3">
                            <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-map-marked-alt me-1"></i>
                                Lihat di Google Maps
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Batal
                </button>

                <form action="{{ route('payment.tagihan.awal.kirim', $item->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane me-1"></i>
                        Kirim Tagihan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection