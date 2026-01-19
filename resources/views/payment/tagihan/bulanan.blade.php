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
    
    .status-belum-bayar {
        background-color: #f3f4f6;
        color: #374151;
    }
    
    .status-dikirim {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .status-menunggu-verifikasi {
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
    
    .btn-action {
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.875rem;
        margin: 0 2px;
        transition: all 0.2s ease;
    }
    
    .btn-outline-primary {
        border-color: #0066cc;
        color: #0066cc;
    }
    
    .btn-outline-primary:hover {
        background-color: #0066cc;
        border-color: #0066cc;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 102, 204, 0.2);
    }
    
    .btn-success {
        background-color: #10b981;
        border-color: #10b981;
    }
    
    .btn-success:hover {
        background-color: #059669;
        border-color: #059669;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
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
    
    .alert {
        border-radius: 8px;
        border: none;
    }
    
    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        color: #991b1b;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-file-invoice-dollar me-3"></i>Daftar Tagihan Bulanan
                    </h2>
                    <p class="mb-0 opacity-90">Kelola tagihan bulanan pelanggan</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-calendar-month me-1"></i>
                            {{ $bulanan->count() }} Tagihan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center mb-4">
                <i class="fas fa-check-circle me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center mb-4">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <div class="schedule-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pelanggan</th>
                            <th>Paket</th>
                            <th>Bulan</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Bukti</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bulanan as $t)
                        <tr>
                            
                            {{-- PELANGGAN --}}
                            <td>
                                @if ($t->pelanggan)
                                    <strong>{{ $t->pelanggan->nama ?? '-' }}</strong><br>
                                    <small class="text-muted">
                                        <i class="fas fa-phone me-1"></i>
                                        {{ $t->pelanggan->no_hp ?? '-' }}
                                    </small>
                                @else
                                    <span class="text-danger">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        Pelanggan tidak ditemukan
                                    </span>
                                @endif
                            </td>

                            {{-- PAKET --}}
                            <td>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-wifi me-1"></i>
                                    {{ optional($t->paket)->nama_paket ?? '-' }}
                                </span>
                            </td>

                            {{-- BULAN --}}
                            <td>
                                <span class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $t->tanggal_pesan
                                        ? \Carbon\Carbon::parse($t->tanggal_pesan)->translatedFormat('d F Y')
                                        : \Carbon\Carbon::createFromFormat('Y-m', $t->bulan)->translatedFormat('F Y')
                                    }}
                                </span>
                            </td>

                            {{-- TOTAL --}}
                            <td class="text-end fw-bold text-success">
                                Rp {{ number_format($t->nominal, 0, ',', '.') }}
                            </td>

                            {{-- BUKTI PEMBAYARAN --}}
                            <td class="text-center">
                                @if($t->bukti_pembayaran)
                                    <button class="btn btn-sm btn-outline-primary btn-action"
                                            data-bs-toggle="modal"
                                            data-bs-target="#bukti{{ $t->id }}"
                                            title="Lihat Bukti">
                                        <i class="fas fa-image"></i>
                                    </button>
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-times-circle"></i>
                                        Belum ada
                                    </span>
                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td class="text-center">
                                @if($t->status == 'belum_bayar')
                                    <span class="status-badge status-belum-bayar">
                                        <i class="fas fa-clock"></i>
                                        Belum Bayar
                                    </span>
                                @elseif($t->status == 'dikirim')
                                    <span class="status-badge status-dikirim">
                                        <i class="fas fa-paper-plane"></i>
                                        Dikirim
                                    </span>
                                @elseif($t->status == 'menunggu_verifikasi')
                                    <span class="status-badge status-menunggu-verifikasi">
                                        <i class="fas fa-hourglass-half"></i>
                                        Menunggu Verifikasi
                                    </span>
                                @elseif($t->status == 'lunas')
                                    <span class="status-badge status-lunas">
                                        <i class="fas fa-check-circle"></i>
                                        Lunas
                                    </span>
                                @elseif($t->status == 'ditolak')
                                    <span class="status-badge status-ditolak">
                                        <i class="fas fa-times-circle"></i>
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="text-center">
                                @if($t->status == 'belum_bayar')
                                    <button type="button"
                                            class="btn btn-sm btn-success btn-action"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detail{{ $t->id }}"
                                            title="Kirim Tagihan">
                                        <i class="fas fa-paper-plane"></i>
                                        Kirim
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📄</div>
                                    <h5>Tidak Ada Tagihan Bulanan</h5>
                                    <p>Belum ada tagihan bulanan yang tersedia saat ini</p>
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

{{-- ================= MODAL DETAIL TAGIHAN - DIPINDAH KE LUAR TABEL ================= --}}
@foreach ($bulanan as $t)
<div class="modal fade" id="detail{{ $t->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-file-invoice me-2"></i>
                    Detail & Konfirmasi Tagihan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted">Pelanggan</h6>
                            <p class="mb-0 fw-semibold">{{ $t->pelanggan->nama ?? '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">No HP</h6>
                            <p class="mb-0">{{ $t->pelanggan->no_hp ?? '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">Paket</h6>
                            <p class="mb-0">{{ optional($t->paket)->nama_paket ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted">Bulan Tagihan</h6>
                            <p class="mb-0">
                                {{ \Carbon\Carbon::createFromFormat('Y-m', $t->bulan)->translatedFormat('F Y') }}
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">Jatuh Tempo</h6>
                            <p class="mb-0">
                                {{ \Carbon\Carbon::parse($t->jatuh_tempo)->format('d M Y') }}
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">Total</h6>
                            <p class="mb-0 fw-bold text-success">
                                Rp {{ number_format($t->nominal, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <h6 class="text-muted">Status</h6>
                    <span class="status-badge status-belum-bayar">
                        <i class="fas fa-clock"></i>
                        Belum Bayar
                    </span>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Batal
                </button>

                <form action="{{ route('payment.tagihan.kirim', $t->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-success">
                        <i class="fas fa-paper-plane me-1"></i>
                        Kirim Tagihan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL PREVIEW BUKTI PEMBAYARAN - DIPINDAH KE LUAR TABEL ================= --}}
@if($t->bukti_pembayaran)
<div class="modal fade" id="bukti{{ $t->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-image me-2"></i>
                    Bukti Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center p-4">
                <img src="{{ asset('storage/'.$t->bukti_pembayaran) }}"
                     class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

@endsection