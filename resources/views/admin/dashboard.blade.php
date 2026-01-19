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
    
    .activity-item {
        transition: background-color 0.2s ease;
    }
    
    .activity-item:hover {
        background-color: #f8fafc;
    }
    
    .technician-rank {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
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
                        <i class="fas fa-tachometer-alt me-3"></i>Dashboard Admin
                    </h2>
                    <p class="mb-0 opacity-90">Selamat datang kembali, <strong>{{ session('user')->nama }}</strong>!</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Key Performance Indicators -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="card-icon bg-primary bg-opacity-10">
                                <i class="fas fa-users text-primary fs-4"></i>
                            </div>
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                                Pelanggan
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $totalPelanggan ?? 0 }}</h3>
                        <p class="text-muted mb-0">Total Pelanggan</p>
                        
                        @if($totalPelanggan > 0)
                            @php $progress = min(($totalPelanggan / 50) * 25, 100); @endphp
                            <div class="progress mt-3" style="height: 4px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%"></div>
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

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="card-icon bg-warning bg-opacity-10">
                                <i class="fas fa-hourglass-half text-warning fs-4"></i>
                            </div>
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">
                                Pending
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $paymentPending ?? 0 }}</h3>
                        <p class="text-muted mb-0">Pembayaran Pending</p>
                        
                        @if($paymentPending > 0)
                            @php $progress = ($totalPayment ?? 0) > 0 ? ($paymentPending / $totalPayment) * 100 : 0; @endphp
                            <div class="progress mt-3" style="height: 4px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">0</small>
                                <small class="text-warning"><i class="fas fa-clock me-1"></i>Perlu ditindaklanjuti</small>
                            </div>
                        @else
                            <div class="text-center mt-3">
                                <span class="text-muted small fst-italic">Tidak ada pending</span>
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
                                <i class="fas fa-tools text-info fs-4"></i>
                            </div>
                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">
                                Teknisi
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $totalTeknisi ?? 0 }}</h3>
                        <p class="text-muted mb-0">Total Teknisi</p>
                        
                        @if($totalTeknisi > 0)
                            @php $progress = min(($totalTeknisi / 5) * 25, 100); @endphp
                            <div class="progress mt-3" style="height: 4px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $progress }}%"></div>
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
        </div>

        <!-- New Orders Section -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">
                                <i class="fas fa-shopping-cart me-2 text-primary"></i>
                                Pesanan Baru
                            </h5>
                            <a href="{{ route('admin.pesanan.index') }}" class="btn btn-sm btn-outline-primary">
                                Lihat Semua
                            </a>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Pelanggan</th>
                                        <th>Paket</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(($newOrders ?? []) as $order)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                {{ $order->invoice_code ?? '—' }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>{{ $order->pelanggan->nama ?? '-' }}</strong><br>
                                            <small class="text-muted">{{ $order->pelanggan->no_hp ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $order->paket->nama_paket ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ $order->created_at->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($order->status == 'pending')
                                                <span class="status-badge status-pending">
                                                    <i class="fas fa-clock"></i>
                                                    Pending
                                                </span>
                                            @elseif($order->status == 'menunggu_survei')
                                                <span class="status-badge status-menunggu_survei">
                                                    <i class="fas fa-search"></i>
                                                    Menunggu Survei
                                                </span>
                                            @elseif($order->status == 'survei_selesai')
                                                <span class="status-badge status-survei_selesai">
                                                    <i class="fas fa-check-circle"></i>
                                                    Survei Selesai
                                                </span>
                                            @elseif($order->status == 'menunggu_pembayaran')
                                                <span class="status-badge status-menunggu_pembayaran">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                    Menunggu Pembayaran
                                                </span>
                                            @elseif($order->status == 'siap_instalasi')
                                                <span class="status-badge status-siap_instalasi">
                                                    <i class="fas fa-tools"></i>
                                                    Siap Instalasi
                                                </span>
                                            @elseif($order->status == 'selesai')
                                                <span class="status-badge status-selesai">
                                                    <i class="fas fa-check-circle"></i>
                                                    Selesai
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                           
   <button
    type="button"
    class="btn btn-sm btn-outline-primary"
    data-bs-toggle="modal"
    data-bs-target="#detailModal{{ $order->id }}">
    <i class="fas fa-eye"></i>
</button>



                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="empty-state">
                                                <div class="empty-state-icon">📦</div>
                                                <h5>Tidak Ada Pesanan Baru</h5>
                                                <p>Belum ada pesanan baru yang perlu diproses</p>
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

            <div class="col-lg-4">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-chart-pie me-2 text-primary"></i>
                            Status Pesanan
                        </h5>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Pending</span>
                                <span class="fw-bold">{{ $orderStats['pending'] ?? 0 }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-secondary" role="progressbar" 
                                     style="width: {{ ($totalOrders ?? 0) > 0 ? (($orderStats['pending'] ?? 0) / ($totalOrders ?? 1)) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Menunggu Survei</span>
                                <span class="fw-bold">{{ $orderStats['menunggu_survei'] ?? 0 }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" 
                                     style="width: {{ ($totalOrders ?? 0) > 0 ? (($orderStats['menunggu_survei'] ?? 0) / ($totalOrders ?? 1)) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Survei Selesai</span>
                                <span class="fw-bold">{{ $orderStats['survei_selesai'] ?? 0 }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" role="progressbar" 
                                     style="width: {{ ($totalOrders ?? 0) > 0 ? (($orderStats['survei_selesai'] ?? 0) / ($totalOrders ?? 1)) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Menunggu Pembayaran</span>
                                <span class="fw-bold">{{ $orderStats['menunggu_pembayaran'] ?? 0 }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" role="progressbar" 
                                     style="width: {{ ($totalOrders ?? 0) > 0 ? (($orderStats['menunggu_pembayaran'] ?? 0) / ($totalOrders ?? 1)) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Siap Instalasi</span>
                                <span class="fw-bold">{{ $orderStats['siap_instalasi'] ?? 0 }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" role="progressbar" 
                                     style="width: {{ ($totalOrders ?? 0) > 0 ? (($orderStats['siap_instalasi'] ?? 0) / ($totalOrders ?? 1)) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Selesai</span>
                                <span class="fw-bold">{{ $orderStats['selesai'] ?? 0 }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: {{ ($totalOrders ?? 0) > 0 ? (($orderStats['selesai'] ?? 0) / ($totalOrders ?? 1)) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart and Business Metrics -->
        <div class="row g-4 mb-4">
            <!-- Revenue Chart -->
            <div class="col-lg-8">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-chart-area me-2 text-primary"></i>
                            Grafik Pendapatan 6 Bulan Terakhir
                        </h5>
                        <div class="chart-container">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Business Metrics -->
            <div class="col-lg-4">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-chart-pie me-2 text-primary"></i>
                            Metrik Bisnis
                        </h5>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Tingkat Konversi</span>
                                <span class="fw-bold text-success">68%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 68%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Retensi Pelanggan</span>
                                <span class="fw-bold text-primary">92%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 92%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Efisiensi Operasional</span>
                                <span class="fw-bold text-info">85%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 85%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Rating Rata-rata</span>
                                <span class="fw-bold text-warning">4.8/5.0</span>
                            </div>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities and Top Technicians -->
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
                                    <small class="text-muted">{{ $activity['time'] }}</small>
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

            <!-- Top Technicians -->
            <div class="col-lg-6">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">
                                <i class="fas fa-trophy me-2 text-primary"></i>
                                Teknisi Terbaik Bulan Ini
                            </h5>
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                Lihat Semua
                            </a>
                        </div>
                        
                        <div class="technician-list">
                            @forelse(($topTechnicians ?? []) as $index => $technician)
                            <div class="d-flex align-items-center mb-3 p-2 rounded activity-item">
                                <div class="technician-rank bg-{{ $index == 0 ? 'warning' : ($index == 1 ? 'secondary' : 'dark') }} text-white me-3">
                                    @if($index == 0)
                                        <i class="fas fa-trophy"></i>
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-medium">{{ $technician['name'] }}</p>
                                    <small class="text-muted">{{ $technician['completed'] }} pesanan selesai</small>
                                </div>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i> {{ $technician['rating'] }}
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-users text-muted mb-3" style="font-size: 2rem;"></i>
                                <p class="text-muted">Belum ada data teknisi</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL DETAIL PESANAN ================= --}}
@foreach($newOrders as $order)
<div class="modal fade" id="detailModal{{ $order->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-1"></i> Detail Pesanan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><strong>Pelanggan:</strong> {{ $order->pelanggan->nama ?? '-' }}</p>
                <p><strong>Paket:</strong> {{ $order->paket->nama_paket ?? '-' }}</p>
                <p><strong>Status:</strong>
                    <span class="badge bg-info">{{ $order->status }}</span>
                </p>

                <hr>

                <p><strong>Laporan Teknisi:</strong>
                    {{ $order->laporan_teknisi ?? 'Belum ada' }}
                </p>

                <hr>

                <p><strong>Koordinat Lokasi:</strong></p>
                <ul>
                    <li>Latitude: {{ $order->latitude ?? '-' }}</li>
                    <li>Longitude: {{ $order->longitude ?? '-' }}</li>
                </ul>

                @if($order->latitude && $order->longitude)
                    <a href="https://www.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}"
                       target="_blank"
                       class="btn btn-outline-primary btn-sm">
                        📍 Lihat di Google Maps
                    </a>
                @endif
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach
{{-- ================= END MODAL ================= --}}


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const canvas = document.getElementById('revenueChart');
    if (!canvas) return;

    // destroy kalau ada chart lama
    if (window.revenueChart instanceof Chart) {
        window.revenueChart.destroy();
    }

    const ctx = canvas.getContext('2d');

    window.revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($last6Months),
            datasets: [{
                label: 'Pendapatan',
                data: @json($revenueData),
                backgroundColor: 'rgba(0, 102, 204, 0.1)',
                borderColor: '#0066cc',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#0066cc',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => 'Rp ' + value.toLocaleString('id-ID')
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>

@endpush

@endsection