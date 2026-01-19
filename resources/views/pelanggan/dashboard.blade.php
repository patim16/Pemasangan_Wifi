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
    
    .stat-card {
        border: 1px solid #e3e8f0;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .card-icon {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
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
        background-color: #f3f4f6;
        color: #374151;
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
    
    .progress {
        background-color: rgba(0,0,0,0.05);
    }
    
    .badge {
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .payment-method {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 8px;
        margin-bottom: 8px;
    }
    
    .payment-method:hover {
        background-color: #f8fafc;
    }
    
    .payment-method-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        margin-right: 12px;
    }
    
    .seabank {
        background-color: #0066cc;
        color: white;
    }
    
    .dana {
        background-color: #00a8e8;
        color: white;
    }
    
    .cash {
        background-color: #059669;
        color: white;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-user-circle me-3"></i>Dashboard Pelanggan
                    </h2>
                    <p class="mb-0 opacity-90">Selamat datang kembali, <strong>{{ session('user')->nama }}</strong>!</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-calendar-day me-1"></i>
                            {{ now()->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Notifikasi -->
        @forelse ($notifikasi ?? [] as $item)
            @if ($item->status == 'jadwal_instalasi')
                <div class="alert alert-info d-flex align-items-center mb-4">
                    <i class="fas fa-calendar-check me-3 fs-4"></i>
                    <div>
                        <strong>Jadwal Instalasi</strong><br>
                        Paket <strong>{{ $item->paket->nama_paket ?? '-' }}</strong><br>
                        Akan dipasang pada: <strong>{{ \Carbon\Carbon::parse($item->jadwal_instalasi)->format('d M Y, H:i') }}</strong>
                    </div>
                </div>
            @endif

            @if ($item->status == 'selesai')
                <div class="alert alert-success d-flex align-items-center mb-4">
                    <i class="fas fa-check-circle me-3 fs-4"></i>
                    <div>
                        <strong>Instalasi Selesai</strong><br>
                        Paket <strong>{{ $item->paket->nama_paket ?? '-' }}</strong> telah berhasil dipasang.
                    </div>
                </div>
            @endif
        @empty
            <div class="alert alert-secondary d-flex align-items-center mb-4">
                <i class="fas fa-info-circle me-3 fs-4"></i>
                <div>
                    Belum ada notifikasi saat ini
                </div>
            </div>
        @endforelse

              <!-- Informasi Paket Aktif -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-wifi me-2 text-primary"></i>
                            Paket Aktif Anda
                        </h5>
                        
                        @if(isset($paket))  <!-- PERUBAHAN 1: Dari $activePackage menjadi $paket -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="fw-bold mb-1">{{ $paket->nama_paket ?? '-' }}</h4>  <!-- PERUBAHAN 2 -->
                                <p class="text-muted mb-0">{{ $paket->deskripsi ?? '-' }}</p>  <!-- PERUBAHAN 3 -->
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-primary fs-5">Rp {{ number_format($paket->harga ?? 0, 0, ',', '.') }}</div>  <!-- PERUBAHAN 4 -->
                                <div class="text-muted">per bulan</div>
                            </div>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-tachometer-alt text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted">Kecepatan</small>
                                        <div class="fw-semibold">{{ $paket->kecepatan ?? '-' }}</div>  <!-- PERUBAHAN 5 -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted">Aktif Sejak</small>
                                        <div class="fw-semibold">{{ $activeSince ? $activeSince->format('d M Y') : '-' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-sync-alt text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted">Tagihan Berikutnya</small>
                                        <div class="fw-semibold">{{ $nextBillDate ? $nextBillDate->format('d M Y') : '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-wifi text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5>Belum Ada Paket Aktif</h5>
                            <p class="text-muted">Anda belum memiliki paket internet yang aktif saat ini.</p>
                            <a href="{{ route('pelanggan.pesanwifi') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-plus me-1"></i> Berlangganan Sekarang
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- ... bagian Status Pembayaran tetap sama ... -->

            <div class="col-lg-4">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-credit-card me-2 text-primary"></i>
                            Status Pembayaran
                        </h5>
                        
                        @if($currentBill)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Bulan Tagihan</span>
                                <span class="fw-semibold">{{ $nextBillDate->format('F Y') }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Jumlah</span>
                                <span class="fw-bold text-success">
                                  Rp {{ number_format($currentBill->nominal,0,',','.') }}

                                </span>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Status</span>
                              <span class="badge 
    {{ $currentBill->status == 'lunas' ? 'bg-success' : 'bg-warning' }}">
    {{ strtoupper($currentBill->status) }}
</span>

                            </div>

                            @if($currentBill->status != 'lunas')
                                <a href="{{ route('pelanggan.tagihan') }}" class="btn btn-primary w-100">
                                    <i class="fas fa-money-bill-wave me-1"></i> Bayar Sekarang
                                </a>
                            @endif
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-credit-card text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5>Belum Ada Tagihan</h5>
                            <p class="text-muted">Belum ada tagihan yang perlu dibayar saat ini.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Cara Pembayaran dan Riwayat -->
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-money-bill-wave me-2 text-primary"></i>
                            Cara Pembayaran
                        </h5>
                        
                        <div class="payment-method">
                            <div class="payment-method-icon seabank">
                                <i class="fas fa-ship"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">SeaBank</div>
                                <small class="text-muted">Transfer ke Virtual Account SeaBank</small>
                            </div>
                        </div>
                        
                        <div class="payment-method">
                            <div class="payment-method-icon dana">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">Dana</div>
                                <small class="text-muted">Scan QRIS atau transfer ke Dana</small>
                            </div>
                        </div>
                        
                        <div class="payment-method">
                            <div class="payment-method-icon cash">
                                <i class="fas fa-money-bill"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">Cash</div>
                                <small class="text-muted">Pembayaran tunai langsung ke kantor</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">
                                <i class="fas fa-history me-2 text-primary"></i>
                                Riwayat Transaksi
                            </h5>
                          <a href="{{ route('pelanggan.riwayat-transaksi') }}" class="btn btn-sm btn-outline-primary">
    Lihat Semua
</a>

                        </div>
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transaksi as $payment)
                                    <tr>
                                        <td>
                                            {{ \Carbon\Carbon::parse($payment->created_at)->format('F Y') }}
                                        </td>

                                        <td class="fw-bold">
                                            Rp {{ number_format($payment->total, 0, ',', '.') }}
                                        </td>

                                      

                                        <td>
                                            @if($payment->status == 'belum_bayar')
                                                <span class="status-badge status-pending">
                                                    <i class="fas fa-clock"></i> Belum Bayar
                                                </span>
                                            @elseif($payment->status == 'terverifikasi')
                                                <span class="status-badge status-menunggu_verifikasi">
                                                    <i class="fas fa-hourglass-half"></i> Menunggu Verifikasi
                                                </span>
                                            @elseif($payment->status == 'lunas')
                                                <span class="status-badge status-lunas">
                                                    <i class="fas fa-check-circle"></i> Lunas
                                                </span>
                                            @elseif($payment->status == 'ditolak')
                                                <span class="status-badge status-pending">
                                                    <i class="fas fa-times-circle"></i> Ditolak
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($payment->status == 'belum_bayar' || $payment->status == 'ditolak')
                                               <a href="{{ route('pelanggan.riwayat-transaksi') }}" class="btn btn-sm btn-primary">
    <i class="fas fa-eye"></i>
</a>

                                            @elseif($payment->status == 'terverifikasi' || $payment->status == 'lunas')
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bukti{{ $payment->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="empty-state">
                                                <div class="empty-state-icon">💳</div>
                                                <h5>Belum Ada Riwayat Pembayaran</h5>
                                                <p>Anda belum memiliki riwayat pembayaran saat ini</p>
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
        </div>

        <!-- Bantuan -->
        <div class="stat-card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-question-circle me-2 text-primary"></i>
                    Butuh Bantuan?
                </h5>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="card-icon bg-primary bg-opacity-10 mx-auto mb-3">
                                <i class="fas fa-headset text-primary fs-4"></i>
                            </div>
                            <h6 class="fw-bold">Hubungi Kami</h6>
                            <p class="text-muted small">Butuh bantuan teknis atau informasi lebih lanjut?</p>
                            <a href="tel:123456789" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-phone me-1"></i> 0815-7368-8460
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="card-icon bg-success bg-opacity-10 mx-auto mb-3">
                                <i class="fas fa-comments text-success fs-4"></i>
                            </div>
                            <h6 class="fw-bold">Live Chat</h6>
                            <p class="text-muted small">Chat langsung dengan tim support kami</p>
                            <button class="btn btn-sm btn-outline-success">
                                <i class="fas fa-comment me-1"></i> Mulai Chat
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="card-icon bg-info bg-opacity-10 mx-auto mb-3">
                                <i class="fas fa-book text-info fs-4"></i>
                            </div>
                            <h6 class="fw-bold">Panduan</h6>
                            <p class="text-muted small">Cari tahu cara menggunakan layanan kami</p>
                            <a href="#" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-book-open me-1"></i> Baca Panduan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bukti Pembayaran -->
@foreach($transaksi as $payment)
    @if($payment->status == 'terverifikasi' && $payment->bukti_pembayaran)
    <div class="modal fade" id="bukti{{ $payment->id }}" tabindex="-1">
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
                    <img src="{{ asset('storage/'.$payment->bukti_pembayaran) }}"
                         class="img-fluid rounded shadow" alt="Bukti Pembayaran">
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

@endsection