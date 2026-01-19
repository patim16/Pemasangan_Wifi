@extends('layout.app')

@section('content')
<style>
    /* Clean Blue Theme - Same as Other Pages */
    .page-header {
        background-color: #0066cc;
        color: white;
         padding: 1.8rem 0;
        margin-bottom: 2rem;
    }
    
    /* Tambahkan CSS ini untuk mengatasi masalah tumpang tindih */
    .main-content {
        margin-left: 250px; /* Sesuaikan dengan lebar sidebar Anda */
        padding-top: 60px; /* Sesuaikan dengan tinggi navbar Anda */
        transition: margin-left 0.3s;
    }
    
    @media (max-width: 991.98px) {
        .main-content {
            margin-left: 0;
        }
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
    padding-top: 10px;
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
    
    .activity-item {
        transition: background-color 0.2s ease;
    }
    
    .activity-item:hover {
        background-color: #f8fafc;
    }
    
    .system-health-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .system-health-item:last-child {
        border-bottom: none;
    }
    
    .health-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 12px;
    }
    
    .health-good {
        background-color: #10b981;
    }
    
    .health-warning {
        background-color: #f59e0b;
    }
    
    .health-critical {
        background-color: #ef4444;
    }
</style>

<!-- Tambahkan class main-content di sini -->
<div class="main-content">
    <div class="container-fluid p-0">
        <!-- Clean Blue Header - Same Style as Other Pages -->
        <div class="page-header">
           <div class="container-fluid px-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2 fw-bold">
                            <i class="fas fa-user-shield me-3"></i>Dashboard Super Admin
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

       <div class="container-fluid px-4">
            <!-- User Management Statistics -->
            <div class="row g-4 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="card-icon bg-primary bg-opacity-10">
                                    <i class="fas fa-user-shield text-primary fs-4"></i>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                                    Admin
                                </span>
                            </div>
                            <h3 class="fw-bold mb-1">{{ $totalAdmin ?? 0 }}</h3>
                            <p class="text-muted mb-0">Total Admin</p>
                            
                            @if($totalAdmin > 0)
                                @php $progress = min(($totalAdmin / 5) * 25, 100); @endphp
                                <div class="progress mt-3" style="height: 4px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">0</small>
                                    <small class="text-success"><i class="fas fa-arrow-up me-1"></i>5% dari bulan lalu</small>
                                </div>
                            @else
                                <div class="text-center mt-3">
                                    <span class="text-muted small fst-italic">Belum ada admin</span>
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
                                    <i class="fas fa-users text-info fs-4"></i>
                                </div>
                                <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">
                                    Pelanggan
                                </span>
                            </div>
                            <h3 class="fw-bold mb-1">{{ $totalPelanggan ?? 0 }}</h3>
                            <p class="text-muted mb-0">Total Pelanggan</p>
                            
                            @if($totalPelanggan > 0)
                                @php $progress = min(($totalPelanggan / 50) * 25, 100); @endphp
                                <div class="progress mt-3" style="height: 4px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $progress }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">0</small>
                                    <small class="text-success"><i class="fas fa-arrow-up me-1"></i>12% dari bulan lalu</small>
                                </div>
                            @else
                                <div class="text-center mt-3">
                                    <span class="text-muted small fst-italic">Belum ada pelanggan</span>
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
                                    <i class="fas fa-tools text-warning fs-4"></i>
                                </div>
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">
                                    Teknisi
                                </span>
                            </div>
                            <h3 class="fw-bold mb-1">{{ $totalTeknisi ?? 0 }}</h3>
                            <p class="text-muted mb-0">Total Teknisi</p>
                            
                            @if($totalTeknisi > 0)
                                @php $progress = min(($totalTeknisi / 10) * 25, 100); @endphp
                                <div class="progress mt-3" style="height: 4px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $progress }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">0</small>
                                    <small class="text-info"><i class="fas fa-dash me-1"></i>Tidak ada perubahan</small>
                                </div>
                            @else
                                <div class="text-center mt-3">
                                    <span class="text-muted small fst-italic">Belum ada teknisi</span>
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
                            <h3 class="fw-bold mb-1">Rp {{ number_format($totalPenghasilan ?? 0, 0, ',', '.') }}</h3>
                            <p class="text-muted mb-0">Pendapatan Bulan Ini</p>
                            
                            @if($totalPenghasilan > 0)
                                @php $progress = min(($totalPenghasilan / 10000000) * 25, 100); @endphp
                                <div class="progress mt-3" style="height: 4px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">0</small>
                                    <small class="text-success"><i class="fas fa-arrow-up me-1"></i>18% dari bulan lalu</small>
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

            <!-- System Health and User Growth -->
            <div class="row g-4 mb-4">
                <!-- System Health -->
                <div class="col-lg-4">
                    <div class="stat-card">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="fas fa-heartbeat me-2 text-primary"></i>
                                Kesehatan Sistem
                            </h5>
                            
                            <div class="system-health-item">
                                <div class="health-indicator health-good"></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-medium">Server Uptime</span>
                                        <span class="text-success">99.9%</span>
                                    </div>
                                    <div class="progress mt-1" style="height: 4px;">
                                        <div class="progress-bar bg-success" style="width: 99.9%"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="system-health-item">
                                <div class="health-indicator health-good"></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-medium">Penggunaan CPU</span>
                                        <span class="text-success">45%</span>
                                    </div>
                                    <div class="progress mt-1" style="height: 4px;">
                                        <div class="progress-bar bg-success" style="width: 45%"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="system-health-item">
                                <div class="health-indicator health-warning"></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-medium">Penggunaan Storage</span>
                                        <span class="text-warning">78%</span>
                                    </div>
                                    <div class="progress mt-1" style="height: 4px;">
                                        <div class="progress-bar bg-warning" style="width: 78%"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="system-health-item">
                                <div class="health-indicator health-good"></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-medium">Database</span>
                                        <span class="text-success">Normal</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="system-health-item">
                                <div class="health-indicator health-good"></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-medium">Backup Terakhir</span>
                                        <span class="text-success">{{ now()->subDays(1)->format('d M') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Growth Chart -->
                <div class="col-lg-8">
                    <div class="stat-card">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="fas fa-chart-line me-2 text-primary"></i>
                                Pertumbuhan Pengguna 6 Bulan Terakhir
                            </h5>
                            <div class="chart-container">
                                <canvas id="userGrowthChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Business Analytics -->
            <div class="row g-4 mb-4">
                <!-- Popular Packages -->
                <div class="col-lg-4">
                    <div class="stat-card">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="fas fa-box me-2 text-primary"></i>
                                Paket Terpopuler
                            </h5>
                            
                            @forelse(($popularPackages ?? []) as $index => $package)
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold">{{ $index + 1 }}</span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-medium">{{ $package['name'] }}</div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-muted">{{ $package['count'] }} pelanggan</small>
                                        <small class="text-success">{{ $package['percentage'] }}%</small>
                                    </div>
                                    <div class="progress mt-1" style="height: 4px;">
                                        <div class="progress-bar bg-primary" style="width: {{ $package['percentage'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-box text-muted mb-3" style="font-size: 2rem;"></i>
                                <p class="text-muted">Belum ada data paket</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="col-lg-4">
                    <div class="stat-card">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="fas fa-credit-card me-2 text-primary"></i>
                                Metode Pembayaran
                            </h5>
                            
                            @forelse(($paymentMethods ?? []) as $method)
                            <div class="d-flex align-items-center mb-3">
                                <div class="payment-method-icon {{ strtolower($method['name']) }} me-3">
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
                                    <div class="fw-medium">{{ $method['name'] }}</div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-muted">{{ $method['count'] }} transaksi</small>
                                        <small class="text-success">{{ $method['percentage'] }}%</small>
                                    </div>
                                    <div class="progress mt-1" style="height: 4px;">
                                        <div class="progress-bar bg-success" style="width: {{ $method['percentage'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-credit-card text-muted mb-3" style="font-size: 2rem;"></i>
                                <p class="text-muted">Belum ada data pembayaran</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Order Status -->
                <div class="col-lg-4">
                    <div class="stat-card">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">
                                <i class="fas fa-tasks me-2 text-primary"></i>
                                Status Pesanan
                            </h5>
                            
                            @forelse(($orderStats ?? []) as $status => $count)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                                <span class="fw-bold">{{ $count }}</span>
                            </div>
                            <div class="progress mb-3" style="height: 8px;">
                                @php
                                    $percentage = ($totalOrders ?? 0) > 0 ? ($count / ($totalOrders ?? 1)) * 100 : 0;
                                    $color = 'bg-secondary';
                                    if ($status == 'selesai') $color = 'bg-success';
                                    elseif ($status == 'siap_instalasi' || $status == 'survei_selesai') $color = 'bg-info';
                                    elseif ($status == 'menunggu_pembayaran') $color = 'bg-warning';
                                @endphp
                                <div class="progress-bar {{ $color }}" style="width: {{ $percentage }}%"></div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-tasks text-muted mb-3" style="font-size: 2rem;"></i>
                                <p class="text-muted">Belum ada data pesanan</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities and System Logs -->
            <div class="row g-4">
                <!-- Recent Activities -->
                <div class="col-lg-6">
                    <div class="stat-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">
                                    <i class="fas fa-list me-2 text-primary"></i>
                                    Aktivitas Terbaru
                                </h5>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    Lihat Semua
                                </a>
                            </div>
                            
                            <div class="activity-list">
                                @forelse(($recentActivities ?? []) as $activity)
                                <div class="d-flex align-items-start mb-3 activity-item p-2 rounded">
                                    <div class="bg-{{ $activity['color'] }} bg-opacity-10 p-2 rounded me-3">
                                        <i class="fas fa-{{ $activity['icon'] }} text-{{ $activity['color'] }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-0 small fw-medium">{{ $activity['title'] }}</p>
                                        <small class="text-muted">{{ $activity['user'] }} • {{ $activity['time'] }}</small>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <i class="fas fa-bell-slash text-muted mb-3" style="font-size: 2rem;"></i>
                                    <p class="text-muted">Belum ada aktivitas terbaru</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Logs -->
                <div class="col-lg-6">
                    <div class="stat-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">
                                    <i class="fas fa-exclamation-triangle me-2 text-primary"></i>
                                    Log Sistem Penting
                                </h5>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    Lihat Semua
                                </a>
                            </div>
                            
                            <div class="activity-list">
                                @forelse(($systemLogs ?? []) as $log)
                                <div class="d-flex align-items-start mb-3 activity-item p-2 rounded">
                                    <div class="bg-{{ $log['level'] == 'error' ? 'danger' : ($log['level'] == 'warning' ? 'warning' : 'info') }} bg-opacity-10 p-2 rounded me-3">
                                        <i class="fas fa-{{ $log['level'] == 'error' ? 'times-circle' : ($log['level'] == 'warning' ? 'exclamation-triangle' : 'info-circle') }} text-{{ $log['level'] == 'error' ? 'danger' : ($log['level'] == 'warning' ? 'warning' : 'info') }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-0 small fw-medium">{{ $log['message'] }}</p>
                                        <small class="text-muted">{{ $log['time'] }}</small>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <i class="fas fa-check-circle text-success mb-3" style="font-size: 2rem;"></i>
                                    <p class="text-muted">Tidak ada log sistem penting</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        
        // Chart.js User Growth Chart
        const ctx = document.getElementById('userGrowthChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov'],
                    datasets: [
                        {
                            label: 'Pelanggan',
                            data: [120, 135, 155, 170, 195, 220],
                            backgroundColor: 'rgba(0, 102, 204, 0.1)',
                            borderColor: '#0066cc',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#0066cc',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Teknisi',
                            data: [8, 9, 10, 11, 12, 14],
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            borderColor: '#f59e0b',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#f59e0b',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#0066cc',
                            borderWidth: 1,
                            displayColors: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
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
        }
    });
</script>
@push('styles')
<style>
    .payment-method-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        color: white;
    }
    
    .seabank {
        background-color: #0066cc;
    }
    
    .dana {
        background-color: #00a8e8;
    }
    
    .gopay {
        background-color: #00a8e8;
    }
    
    .ovo {
        background-color: #6b21a8;
    }
    
    .transfer {
        background-color: #059669;
    }

</style>
@endpush

@endsection 