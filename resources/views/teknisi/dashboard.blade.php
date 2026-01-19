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
    
    .status-jadwal_instalasi {
        background-color: #dbeafe;
        color: #1e40af;
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
    
    .task-item {
        transition: background-color 0.2s ease;
    }
    
    .task-item:hover {
        background-color: #f8fafc;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-tools me-3"></i>Dashboard Teknisi
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
        <!-- Key Performance Indicators -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="card-icon bg-primary bg-opacity-10">
                                <i class="fas fa-search text-primary fs-4"></i>
                            </div>
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                                Survei
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $jadwalSurveiHariIni ?? 0 }}</h3>
                        <p class="text-muted mb-0">Jadwal Survei Hari Ini</p>
                        
                        @if(($jadwalSurveiHariIni ?? 0) > 0)
                            @php $progress = min((($jadwalSurveiHariIni ?? 0) / 5) * 25, 100); @endphp
                            <div class="progress mt-3" style="height: 4px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">0</small>
                                <small class="text-primary">Perlu ditindaklanjuti</small>
                            </div>
                        @else
                            <div class="text-center mt-3">
                                <span class="text-muted small fst-italic">Tidak ada jadwal survei</span>
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
                                <i class="fas fa-wifi text-info fs-4"></i>
                            </div>
                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">
                                Instalasi
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $jadwalInstalasiHariIni ?? 0 }}</h3>
                        <p class="text-muted mb-0">Jadwal Instalasi Hari Ini</p>
                        
                        @if(($jadwalInstalasiHariIni ?? 0) > 0)
                            @php $progress = min((($jadwalInstalasiHariIni ?? 0) / 5) * 25, 100); @endphp
                            <div class="progress mt-3" style="height: 4px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">0</small>
                                <small class="text-info">Perlu ditindaklanjuti</small>
                            </div>
                        @else
                            <div class="text-center mt-3">
                                <span class="text-muted small fst-italic">Tidak ada jadwal instalasi</span>
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
                                <i class="fas fa-check-circle text-success fs-4"></i>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                                Selesai
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $tugasSelesai ?? 0 }}</h3>
                        <p class="text-muted mb-0">Tugas Selesai Bulan Ini</p>
                        
                        @if(($totalTugasBulanIni ?? 0) > 0)
                            @php $progress = ($totalTugasBulanIni > 0) ? (($tugasSelesai ?? 0) / $totalTugasBulanIni) * 100 : 0; @endphp
                            <div class="progress mt-3" style="height: 4px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">0</small>
                                <small class="text-success">{{ round($progress) }}% selesai</small>
                            </div>
                        @else
                            <div class="text-center mt-3">
                                <span class="text-muted small fst-italic">Belum ada tugas</span>
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
                                <i class="fas fa-clock text-warning fs-4"></i>
                            </div>
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">
                                Proses
                            </span>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $tugasDalamProses ?? 0 }}</h3>
                        <p class="text-muted mb-0">Tugas Dalam Proses</p>
                        
                        @if(($totalTugasBulanIni ?? 0) > 0)
                            @php $progress = ($totalTugasBulanIni > 0) ? (($tugasDalamProses ?? 0) / $totalTugasBulanIni) * 100 : 0; @endphp
                            <div class="progress mt-3" style="height: 4px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">0</small>
                                <small class="text-warning">{{ round($progress) }}% dalam proses</small>
                            </div>
                        @else
                            <div class="text-center mt-3">
                                <span class="text-muted small fst-italic">Tidak ada tugas</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal Hari Ini dan Grafik Performa -->
        <div class="row g-4 mb-4">
            <!-- Jadwal Hari Ini -->
            <div class="col-lg-8">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">
                                <i class="fas fa-calendar-day me-2 text-primary"></i>
                                Jadwal Hari Ini
                            </h5>
                            <div class="btn-group" role="group">
                                <a href="{{ route('teknisi.jadwal-survei') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-search me-1"></i> Survei
                                </a>
                                <a href="{{ route('teknisi.jadwal-pemasangan') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-wifi me-1"></i> Instalasi
                                </a>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Pelanggan</th>
                                        <th>Layanan</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(($todaySchedules ?? []) as $schedule)
                                    <tr>
                                        <td>
                                            <span class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $schedule->jadwal ? \Carbon\Carbon::parse($schedule->jadwal)->format('H:i') : '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>{{ $schedule->pelanggan->nama ?? '-' }}</strong><br>
                                            <small class="text-muted">{{ $schedule->pelanggan->no_hp ?? '-' }}</small>
                                        </td>
                                        <td>
                                            @if($schedule->jenis == 'survei')
                                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                                    <i class="fas fa-search me-1"></i> Survei
                                                </span>
                                            @else
                                                <span class="badge bg-info bg-opacity-10 text-info">
                                                    <i class="fas fa-wifi me-1"></i> Instalasi
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ $schedule->pelanggan->alamat ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($schedule->status == 'menunggu_survei')
                                                <span class="status-badge status-menunggu_survei">
                                                    <i class="fas fa-search"></i>
                                                    Menunggu Survei
                                                </span>
                                            @elseif($schedule->status == 'survei_selesai')
                                                <span class="status-badge status-survei_selesai">
                                                    <i class="fas fa-check-circle"></i>
                                                    Survei Selesai
                                                </span>
                                            @elseif($schedule->status == 'siap_instalasi')
                                                <span class="status-badge status-siap_instalasi">
                                                    <i class="fas fa-tools"></i>
                                                    Siap Instalasi
                                                </span>
                                            @elseif($schedule->status == 'jadwal_instalasi')
                                                <span class="status-badge status-jadwal_instalasi">
                                                    <i class="fas fa-calendar-check"></i>
                                                    Jadwal Instalasi
                                                </span>
                                            @elseif($schedule->status == 'selesai')
                                                <span class="status-badge status-selesai">
                                                    <i class="fas fa-check-circle"></i>
                                                    Selesai
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                          @if($schedule->jenis == 'survei')
   <button
    class="btn btn-sm btn-outline-primary"
    data-bs-toggle="modal"
    data-bs-target="#detailModal{{ $schedule->id }}"
    title="Detail Survei">
    <i class="fas fa-eye"></i>
</button>

@else
   <button
       class="btn btn-sm btn-outline-info"
    data-bs-toggle="modal"
    data-bs-target="#instalasiModal{{ $schedule->id }}"
    title="Detail Instalasi">
    <i class="fas fa-eye"></i>
</button>
@endif


                                        </td> 
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="empty-state">
                                                <div class="empty-state-icon">📅</div>
                                                <h5>Tidak Ada Jadwal Hari Ini</h5>
                                                <p>Anda tidak memiliki jadwal survei atau instalasi untuk hari ini</p>
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

            <!-- Grafik Performa -->
            <div class="col-lg-4">
                <div class="stat-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-chart-line me-2 text-primary"></i>
                            Performa 7 Hari Terakhir
                        </h5>
                        <div class="chart-container">
                           <canvas
    id="performanceChart"
    data-labels='@js($last7Days ?? ["Sen","Sel","Rab","Kam","Jum","Sab","Min"])'
    data-values='@js($completionData ?? [3,5,4,6,4,7,5])'>
</canvas>

                        </div>
                        
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Rata-rata Penyelesaian</span>
                                <span class="fw-bold text-success">{{ $avgCompletionRate ?? 0 }}%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: {{ $avgCompletionRate ?? 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pekerjaan Terbaru -->
        <div class="stat-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-history me-2 text-primary"></i>
                        Riwayat Pekerjaan Terbaru
                    </h5>
                    <a href="{{ route('teknisi.riwayat-instalasi') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($recentJobs ?? []) as $job)
                            <tr>
                                <td>
                                    <span class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $job->created_at->format('d M Y') }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $job->pelanggan->nama ?? '-' }}</strong><br>
                                    <small class="text-muted">{{ $job->pelanggan->no_hp ?? '-' }}</small>
                                </td>
                                <td>
                                    @if($job->jenis == 'survei')
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            <i class="fas fa-search me-1"></i> Survei
                                        </span>
                                    @else
                                        <span class="badge bg-info bg-opacity-10 text-info">
                                            <i class="fas fa-wifi me-1"></i> Instalasi
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($job->status == 'selesai')
                                        <span class="status-badge status-selesai">
                                            <i class="fas fa-check-circle"></i>
                                            Selesai
                                        </span>
                                    @elseif($job->status == 'survei_selesai')
                                        <span class="status-badge status-survei_selesai">
                                            <i class="fas fa-check-circle"></i>
                                            Survei Selesai
                                        </span>
                                    @elseif($job->status == 'jadwal_instalasi')
                                        <span class="status-badge status-jadwal_instalasi">
                                            <i class="fas fa-calendar-check"></i>
                                            Jadwal Instalasi
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($job->jenis == 'survei')
                                        <a href="{{ route('teknisi.survei.detail', $job->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('teknisi.instalasi.detail', $job->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">🔧</div>
                                        <h5>Belum Ada Riwayat Pekerjaan</h5>
                                        <p>Anda belum memiliki riwayat pekerjaan saat ini</p>
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
<script src="{{ asset('js/teknisi-dashboard.js') }}"></script>
@endpush

{{-- ================= MODAL DETAIL SURVEI (DASHBOARD) ================= --}}
@foreach($todaySchedules as $item)
@if($item->jenis == 'survei')
<div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2"></i>
                    Detail Survei
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Pelanggan</h6>
                        <p class="fw-semibold">{{ $item->pelanggan->nama ?? '-' }}</p>

                        <h6 class="text-muted">No HP</h6>
                        <p>{{ $item->pelanggan->no_hp ?? '-' }}</p>

                        <h6 class="text-muted">Paket</h6>
                        <p>{{ $item->paket->nama_paket ?? '-' }}</p>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-muted">Alamat</h6>
                        <p>{{ $item->alamat ?? '-' }}</p>

                        <h6 class="text-muted">Jadwal Survei</h6>
                        <p>
                            {{ $item->jadwal_survei
                                ? \Carbon\Carbon::parse($item->jadwal_survei)->format('d M Y H:i')
                                : '-' }}
                        </p>

                        <h6 class="text-muted">Status</h6>
                        <span class="badge bg-primary">
                            {{ str_replace('_',' ', ucfirst($item->status)) }}
                        </span>
                    </div>
                </div>

                {{-- 🔥 KOORDINAT LOKASI --}}
                <hr>

                <h6 class="text-muted">Koordinat Lokasi</h6>
                <p class="mb-2">
                    Latitude : {{ $item->latitude ?? '-' }} <br>
                    Longitude: {{ $item->longitude ?? '-' }}
                </p>

                @if($item->latitude && $item->longitude)
                    <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}"
                       target="_blank"
                       class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-map-marked-alt me-1"></i>
                        Buka di Google Maps
                    </a>
                @else
                    <span class="text-muted fst-italic">
                        Lokasi belum tersedia
                    </span>
                @endif
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>
@endif
@endforeach
@endsection