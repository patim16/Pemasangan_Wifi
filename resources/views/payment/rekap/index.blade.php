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
    
    .chart-container {
        position: relative;
        height: 300px;
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
    
    .status-terverifikasi {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-menunggu {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .status-ditolak {
        background-color: #fee2e2;
        color: #991b1b;
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
    
    .avatar {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        background-color: rgba(0, 102, 204, 0.1);
        border-radius: 50%;
        color: #0066cc;
        font-weight: 600;
    }
    
    .payment-method-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
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
    
    .gopay {
        background-color: #00a8e8;
        color: white;
    }
    
    .ovo {
        background-color: #6b21a8;
        color: white;
    }
    
    .transfer {
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
                        <i class="fas fa-file-invoice-dollar me-3"></i>Rekap Transaksi
                    </h2>
                    <p class="mb-0 opacity-90">Analisis dan rekapitulasi transaksi pembayaran</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-calendar-range me-1"></i>
                            {{ now()->format('F Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- FORM FILTER -->
        <div class="stat-card mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-filter me-2 text-primary"></i>
                    Filter Transaksi
                </h5>
                <form method="GET" action="{{ route('payment.rekap.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted">Tanggal Mulai</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fas fa-calendar-alt text-primary"></i>
                            </span>
                            <input type="date" name="start_date" value="{{ $start ?? '' }}" class="form-control border-0 bg-light" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-muted">Tanggal Akhir</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fas fa-calendar-alt text-primary"></i>
                            </span>
                            <input type="date" name="end_date" value="{{ $end ?? '' }}" class="form-control border-0 bg-light" required>
                        </div>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(!$start && !$end)
            <!-- TAMPILAN AWAL - STATISTIK METODE PEMBAYARAN -->
            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="stat-card">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="fas fa-chart-pie me-2 text-primary"></i>
                                Statistik Metode Pembayaran Bulan Ini
                            </h5>
                            <div class="chart-container">
                                <canvas id="paymentMethodChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="stat-card">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="fas fa-list me-2 text-primary"></i>
                                Rincian Metode Pembayaran
                            </h5>
                            
                            @forelse($paymentMethods ?? [] as $method)
                            <div class="d-flex align-items-center mb-3">
                                <div class="payment-method-icon {{ strtolower($method['name']) }}">
                                    @if(strtolower($method['name']) == 'seabank')
                                        <i class="fas fa-ship"></i>
                                    @elseif(strtolower($method['name']) == 'dana')
                                        <i class="fas fa-wallet"></i>
                                    @elseif(strtolower($method['name']) == 'gopay')
                                        <i class="fas fa-mobile-alt"></i>
                                    @elseif(strtolower($method['name']) == 'ovo')
                                        <i class="fas fa-piggy-bank"></i>
                                    @else
                                        <i class="fas fa-exchange-alt"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-semibold">{{ $method['name'] }}</span>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">{{ $method['count'] }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                        <small class="text-muted">Total</small>
                                        <small class="fw-bold text-success">Rp {{ number_format($method['total'], 0, ',', '.') }}</small>
                                    </div>
                                    <div class="progress mt-2" style="height: 4px;">
                                        <div class="progress-bar bg-primary" role="progressbar" 
                                             style="width: {{ $method['percentage'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-credit-card text-muted mb-3" style="font-size: 2rem;"></i>
                                <p class="text-muted">Belum ada data metode pembayaran</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABEL TRANSAKSI TERBARU -->
            <div class="stat-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-list me-2 text-primary"></i>
                            Transaksi Terbaru
                        </h5>
                        <a href="{{ route('payment.list') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Pelanggan</th>
                                    <th>jenis</th>
                                    <th class="text-end">Nominal</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            @forelse(($recentTransactions ?? []) as $transaction)
                            <tr>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        {{ $transaction->invoice_code ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    <div>{{ $transaction->pelanggan->nama ?? '-' }}</div>
                                    <small class="text-muted">{{ $transaction->pelanggan->email ?? '-' }}</small>
                                </td>
                                <td>
                                    @if($transaction->jenis === 'awal')
                                        <span class="badge bg-primary">Tagihan Awal</span>
                                    @else
                                        <span class="badge bg-info">Bulanan</span>
                                    @endif
                                </td>
                                <td class="text-end fw-bold">
                                    Rp {{ number_format($transaction->nominal ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if($transaction->status === 'menunggu_verifikasi')
                                        <span class="status-badge status-menunggu">
                                            <i class="fas fa-clock"></i>
                                            Menunggu
                                        </span>
                                    @elseif($transaction->status === 'lunas' || $transaction->status === 'valid')
                                        <span class="status-badge status-terverifikasi">
                                            <i class="fas fa-check-circle"></i>
                                            Terverifikasi
                                        </span>
                                    @elseif($transaction->status === 'ditolak' || $transaction->status === 'invalid')
                                        <span class="status-badge status-ditolak">
                                            <i class="fas fa-times-circle"></i>
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">{{ $transaction->status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('payment.list') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">💳</div>
                                        <h5>Belum Ada Transaksi</h5>
                                        <p>Belum ada transaksi yang dilakukan saat ini</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <!-- TAMPILAN HASIL FILTER -->
            <div class="alert alert-info d-flex align-items-center mb-4">
                <i class="fas fa-info-circle me-2"></i>
                <div>
                    <strong>Rentang Waktu:</strong> {{ $start }} s/d {{ $end }}
                </div>
            </div>

            <div class="row g-4 mb-4">
                <!-- Total Pendapatan -->
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="card-icon bg-success bg-opacity-10">
                                    <i class="fas fa-money-bill-wave text-success fs-4"></i>
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                                    Total
                                </span>
                            </div>
                            <h3 class="fw-bold mb-1">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h3>
                            <p class="text-muted mb-0">Total Pendapatan</p>
                        </div>
                    </div>
                </div>

                <!-- Total Transaksi -->
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="card-icon bg-primary bg-opacity-10">
                                    <i class="fas fa-receipt text-primary fs-4"></i>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                                    Transaksi
                                </span>
                            </div>
                            <h3 class="fw-bold mb-1">{{ $data->count() ?? 0 }}</h3>
                            <p class="text-muted mb-0">Total Transaksi</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Export -->
            <div class="d-flex gap-2 justify-content-end mb-4">
                <a href="{{ route('payment.rekap.pdf', ['start_date' => $start, 'end_date' => $end]) }}"
                   class="btn btn-danger">
                    <i class="fas fa-file-pdf me-1"></i> Export PDF
                </a>
                <a href="{{ route('payment.rekap.excel', ['start_date' => $start, 'end_date' => $end]) }}"
                   class="btn btn-success">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </a>
            </div>

            <!-- Tabel Hasil Filter -->
            <div class="stat-card">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Pelanggan</th>
                                    <th>Paket</th>
                                    <th>Metode</th>
                                    <th class="text-end">Total</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $t)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-3">
                                                <span>{{ substr($t->pelanggan->nama, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $t->pelanggan->nama }}</div>
                                                <small class="text-muted">{{ $t->pelanggan->email ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $t->paket->nama_paket ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
    <span class="badge bg-light text-dark">
        {{ $t->metodePembayaran->nama_metode ?? '-' }}
    </span>
</td>

                                    <td class="text-end fw-bold">
                                        Rp {{ number_format($t->total, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $t->created_at->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($t->status == 'terverifikasi' || $t->status == 'lunas')
                                            <span class="status-badge status-terverifikasi">
                                                <i class="fas fa-check-circle"></i>
                                                Terverifikasi
                                            </span>
                                        @elseif($t->status == 'menunggu' || $t->status == 'menunggu_verifikasi')
                                            <span class="status-badge status-menunggu">
                                                <i class="fas fa-clock"></i>
                                                Menunggu
                                            </span>
                                        @elseif($t->status == 'ditolak' || $t->status == 'invalid')
                                            <span class="status-badge status-ditolak">
                                                <i class="fas fa-times-circle"></i>
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">📅</div>
                                            <h5>Tidak Ada Transaksi</h5>
                                            <p>Tidak ada transaksi pada rentang tanggal yang dipilih</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Animasi muncul untuk cards
        const cards = document.querySelectorAll('.stat-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.5s ease';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50);
            }, index * 100);
        });
        
        // Animasi progress bar
        setTimeout(() => {
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.transition = 'width 1.5s ease';
                    bar.style.width = width;
                }, 100);
            });
        }, 500);
        
        // Chart.js Payment Method Chart
        @if(!$start && !$end && isset($paymentMethods))
            const ctx = document.getElementById('paymentMethodChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($paymentMethods->pluck('name')),
                        datasets: [{
                            data: @json($paymentMethods->pluck('count')),
                            backgroundColor: [
                                '#0066cc', // SeaBank
                                '#00a8e8', // Dana
                                '#00a8e8', // GoPay
                                '#6b21a8', // OVO
                                '#059669'  // Transfer Bank
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: '#0066cc',
                                borderWidth: 1,
                                displayColors: true,
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} transaksi (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        cutout: '60%'
                    }
                });
            }
        @endif
    });
</script>
@endpush

@endsection