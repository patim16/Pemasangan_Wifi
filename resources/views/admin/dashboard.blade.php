@extends('layout.app')

@section('content')
<div class="container mt-4">

    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2 fw-bold">Dashboard Admin</h1>
                    <p class="text-muted mb-0">
                        Selamat datang kembali, <strong class="text-primary">{{ session('user')->nama }}</strong>!
                    </p>
                </div>
                <div class="text-end">
                    <small class="text-muted d-block">{{ date('l, d F Y') }}</small>
                    <small class="text-muted">{{ date('H:i') }} WIB</small>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 1 -->
    <div class="row g-3 mb-4">

        <!-- Total Pelanggan -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">Total Pelanggan</p>
                            <h3 class="mb-0 fw-bold">{{ $totalPelanggan ?? 0 }}</h3>
                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i> 12% dari bulan lalu
                            </small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-people text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Teknisi -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">Total Teknisi</p>
                            <h3 class="mb-0 fw-bold">{{ $totalTeknisi ?? 0 }}</h3>
                            <small class="text-info">
                                <i class="bi bi-dash"></i> Tidak ada perubahan
                            </small>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-tools text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Penghasilan -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">Total Penghasilan</p>
                            <h3 class="mb-0 fw-bold">Rp {{ number_format($totalPenghasilan ?? 0, 0, ',', '.') }}</h3>
                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i> 18% dari bulan lalu
                            </small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-currency-dollar text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Payment -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">Total Payment</p>
                            <h3 class="mb-0 fw-bold">{{ $totalPayment ?? 0 }}</h3>
                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i> 10% dari bulan lalu
                            </small>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-credit-card text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- END ROW 1 -->


    <!-- ROW 2 -->
    <div class="row g-3 mb-4">

        <!-- Pembayaran Pending -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">Pembayaran Pending</p>
                            <h3 class="mb-0 fw-bold">{{ $paymentPending ?? 0 }}</h3>
                            <small class="text-warning">
                                <i class="bi bi-clock"></i> Perlu ditindaklanjuti
                            </small>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-hourglass-split text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pesanan Aktif -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">Pesanan Aktif</p>
                            <h3 class="mb-0 fw-bold">{{ $pesananAktif ?? 0 }}</h3>
                            <small class="text-primary">
                                <i class="bi bi-arrow-repeat"></i> Sedang diproses
                            </small>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-cart-check text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pesanan Selesai Hari Ini -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">Selesai Hari Ini</p>
                            <h3 class="mb-0 fw-bold">{{ $pesananSelesaiHariIni ?? 0 }}</h3>
                            <small class="text-success">
                                <i class="bi bi-check-circle"></i> Berhasil diselesaikan
                            </small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-check2-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- END ROW 2 -->


    <!-- ROW 3: CHART + QUICK STATS -->
    <div class="row g-3 mb-4">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="mb-0 fw-bold">Grafik Penghasilan</h5>
                    <small class="text-muted">Pendapatan 6 bulan terakhir</small>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- QUICK STATS -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="mb-0 fw-bold">Statistik Cepat</h5>
                    <small class="text-muted">Ringkasan bulan ini</small>
                </div>

                <div class="card-body">

                    <!-- Tingkat Kepuasan -->
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Tingkat Kepuasan</span>
                            <span class="fw-bold text-success">98%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 98%"></div>
                        </div>
                    </div>

                    <!-- Teknisi Tersedia -->
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Teknisi Tersedia</span>
                            <span class="fw-bold text-primary">85%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: 85%"></div>
                        </div>
                    </div>

                    <!-- Pesanan Selesai -->
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Pesanan Selesai Tepat Waktu</span>
                            <span class="fw-bold text-info">92%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" style="width: 92%"></div>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Rating Rata-rata</span>
                            <span class="fw-bold text-warning">4.8/5.0</span>
                        </div>
                        <div class="text-warning">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div> <!-- END ROW 3 -->


    <!-- ROW 4: RECENT ACTIVITY + TOP TEKNISI -->
    <div class="row g-3">

        <!-- Aktivitas -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="mb-0 fw-bold">Aktivitas Terbaru</h5>
                    <small class="text-muted">10 aktivitas terakhir</small>
                </div>

                <div class="card-body p-0">
                    <div class="list-group list-group-flush">

                        <div class="list-group-item border-0 px-3 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-check-circle text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 small fw-medium">Pesanan #1234 telah selesai</p>
                                    <small class="text-muted">5 menit yang lalu</small>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item border-0 px-3 py-3 bg-light bg-opacity-50">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-person-plus text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 small fw-medium">Pelanggan baru terdaftar</p>
                                    <small class="text-muted">15 menit yang lalu</small>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item border-0 px-3 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-credit-card text-warning"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 small fw-medium">Pembayaran menunggu konfirmasi</p>
                                    <small class="text-muted">30 menit yang lalu</small>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item border-0 px-3 py-3 bg-light bg-opacity-50">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-box-seam text-info"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 small fw-medium">Pesanan baru diterima</p>
                                    <small class="text-muted">1 jam yang lalu</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer bg-white border-0 text-center">
                    <a href="#" class="text-decoration-none small fw-medium">
                        Lihat Semua Aktivitas <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

            </div>
        </div>

        <!-- Top Teknisi -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="mb-0 fw-bold">Teknisi Terbaik Bulan Ini</h5>
                    <small class="text-muted">Berdasarkan jumlah pesanan selesai</small>
                </div>

                <div class="card-body p-0">
                    <div class="list-group list-group-flush">

                        <div class="list-group-item border-0 px-3 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="bi bi-trophy-fill"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-medium">Budi Santoso</p>
                                    <small class="text-muted">45 pesanan selesai</small>
                                </div>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i> 4.9
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item border-0 px-3 py-3 bg-light bg-opacity-50">
                            <div class="d-flex align-items-center">
                                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    2
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-medium">Ahmad Wijaya</p>
                                    <small class="text-muted">38 pesanan selesai</small>
                                </div>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i> 4.8
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item border-0 px-3 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    3
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-medium">Dedi Prasetyo</p>
                                    <small class="text-muted">32 pesanan selesai</small>
                                </div>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i> 4.7
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer bg-white border-0 text-center">
                    <a href="#" class="text-decoration-none small fw-medium">
                        Lihat Semua Teknisi <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </div> <!-- END ROW 4 -->

</div>

<!-- STYLE -->
<style>
.card-hover {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15)!important;
}
.card { border-radius: 12px; }
.progress { border-radius: 10px; }
.progress-bar { border-radius: 10px; }
</style>

<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart');
if (ctx) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov'],
            datasets: [{
                label: 'Penghasilan (Juta Rupiah)',
                data: [12, 19, 15, 25, 22, 30],
                borderColor: 'rgb(13, 110, 253)',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false }},
            scales: {
                y: { beginAtZero: true, grid: { display: true, drawBorder: false }},
                x: { grid: { display: false }}
            }
        }
    });
}
</script>

@endsection
