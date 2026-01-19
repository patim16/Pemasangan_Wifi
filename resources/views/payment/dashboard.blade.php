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
    
    .status-menunggu {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .status-terverifikasi {
        background-color: #d1fae5;
        color: #065f46;
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
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-credit-card me-3"></i>Dashboard Payment
                    </h2>
                    <p class="mb-0 opacity-90">Pantau pendapatan dan status pembayaran</p>
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
        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="card-icon bg-primary bg-opacity-10">
                                <i class="fas fa-calendar-check text-primary fs-4"></i>
                            </div>
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                                Hari Ini
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $totalHariIni ?? 0 }}</h3>
                        <p class="text-muted mb-0">Total Transaksi Hari Ini</p>
                        
                        @if(($totalHariIni ?? 0) > 0)
                            @php
                                $progress = min((($totalHariIni ?? 0) / 5) * 25, 100);
                            @endphp
                            <div class="progress mt-3" style="height: 4px;">
                                <div class="progress-bar bg-primary" role="progressbar" 
                                     style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">0</small>
                                <small class="text-muted">{{ $totalHariIni ?? 0 }}</small>
                            </div>
                        @else
                            <div class="text-center mt-3">
                                <span class="text-muted small fst-italic">Belum ada transaksi</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="card-icon bg-success bg-opacity-10">
                                <i class="fas fa-money-bill-wave text-success fs-4"></i>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                                Pendapatan
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1">Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }}</h3>
                        <p class="text-muted mb-0">Pendapatan Hari Ini</p>
                        
                        @if(($pendapatanHariIni ?? 0) > 0)
                            @php
                                $progress = min((($pendapatanHariIni ?? 0) / 1000000) * 25, 100);
                            @endphp
                            <div class="progress mt-3" style="height: 4px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">0</small>
                                <small class="text-muted">Rp 1jt+</small>
                            </div>
                        @else
                            <div class="text-center mt-3">
                                <span class="text-muted small fst-italic">Belum ada pendapatan</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="card-icon bg-warning bg-opacity-10">
                                <i class="fas fa-hourglass-split text-warning fs-4"></i>
                            </div>
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">
                                Pending
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $menunggu ?? 0 }}</h3>
                        <p class="text-muted mb-0">Menunggu Verifikasi</p>
                        
                        @if(($menunggu ?? 0) > 0)
                            @php
                                $progress = ($totalHariIni ?? 0) > 0 ? (($menunggu ?? 0) / ($totalHariIni ?? 1)) * 100 : 0;
                            @endphp
                            <div class="progress mt-3" style="height: 4px;">
                                <div class="progress-bar bg-warning" role="progressbar" 
                                     style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">0</small>
                                <small class="text-muted">{{ round($progress) }}%</small>
                            </div>
                        @else
                            <div class="text-center mt-3">
                                <span class="text-muted small fst-italic">Tidak ada yang menunggu</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="card-icon bg-info bg-opacity-10">
                                <i class="fas fa-chart-line text-info fs-4"></i>
                            </div>
                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">
                                Bulanan
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1">Rp {{ number_format($pendapatanBulanan ?? 0, 0, ',', '.') }}</h3>
                        <p class="text-muted mb-0">Pendapatan Bulan Ini</p>
                        
                        @if(($pendapatanBulanan ?? 0) > 0)
                            @php
                                $progress = min((($pendapatanBulanan ?? 0) / 10000000) * 25, 100);
                            @endphp
                            <div class="progress mt-3" style="height: 4px;">
                                <div class="progress-bar bg-info" role="progressbar" 
                                     style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">0</small>
                                <small class="text-muted">Rp 10jt+</small>
                            </div>
                        @else
                            <div class="text-center mt-3">
                                <span class="text-muted small fst-italic">Belum ada pendapatan</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart and Recent Transactions -->
        <div class="row g-4 mb-4">
            <!-- Revenue Chart -->
            <div class="col-lg-8">
                <div class="stat-card">
                    <div class="card-body p-4">
                       <h5 class="fw-bold mb-4">
    <i class="fas fa-chart-area me-2 text-primary"></i>
    Grafik Pendapatan 6 Bulan Terakhir
</h5>
   
                        <div class="chart-container" style="min-height:300px;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Types -->
          <!-- Ganti bagian ini -->

        <!-- Recent Transactions -->
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
                                <th>Jenis</th>
                                <th class="text-end">Nominal</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($recentTransactions ?? []) as $transaction)
                            <tr>
                                <td>
                                  <span class="badge bg-primary bg-opacity-10 text-primary">
                                     INV-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}
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
    Rp {{ number_format($transaction->total ?? 0, 0, ',', '.') }}
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
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // ===== Delay agar layout Bootstrap sudah stabil =====
    setTimeout(() => {

        const canvas = document.getElementById('revenueChart');

        if (!canvas) {
            console.error('Canvas #revenueChart tidak ditemukan');
            return;
        }

        const ctx = canvas.getContext('2d');

        // Hapus chart lama jika reload halaman via cache
        if (window.revenueChartInstance) {
            window.revenueChartInstance.destroy();
        }

        window.revenueChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($last6Months ?? []),   // 🔥 6 bulan
                datasets: [{
                    label: 'Pendapatan',
                    data: @json($revenueData ?? []),
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    borderColor: '#0066cc',
                    backgroundColor: 'rgba(0, 102, 204, 0.15)',
                    pointBackgroundColor: '#0066cc',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1200,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const value = context.parsed.y || 0;
                                return 'Pendapatan: Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        console.log('Chart pendapatan berhasil dirender');

    }, 400); // ⏱ delay WAJIB

});
</script>
@endpush

@endsection