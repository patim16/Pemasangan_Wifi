@extends('layout.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3">
    <div class="row">
        <div class="col-12">
            {{-- Header Section --}}
            <div class="mb-3">
                <h4 class="fw-bold mb-1 text-dark">Dashboard Teknisi</h4>
                <p class="text-muted mb-0">
                    Selamat datang, <strong>{{ session('user')->nama }}</strong>!
                </p>
            </div>

            {{-- Menu Cards --}}
            <div class="row g-3">
                {{-- Jadwal Hari Ini --}}
                <div class="col-md-4">
                    <div class="menu-card h-100 shadow-sm border-0">
                        <div class="menu-content">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle-md bg-info bg-opacity-10 me-3">
                                    <i class="bi bi-calendar-event text-info fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="menu-title mb-1">Jadwal Hari Ini</h6>
                                    <p class="menu-desc mb-0">2 Instalasi terjadwal</p>
                                </div>
                            </div>
                            <a href="{{ route('teknisi.jadwal-pemasangan') }}" class="btn btn-info btn-sm w-100 mt-auto">
                                <i class="bi bi-eye me-1"></i>Lihat Jadwal
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Update Status --}}
                <div class="col-md-4">
                    <div class="menu-card h-100 shadow-sm border-0">
                        <div class="menu-content">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle-md bg-warning bg-opacity-10 me-3">
                                    <i class="bi bi-arrow-repeat text-warning fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="menu-title mb-1">Update Status</h6>
                                    <p class="menu-desc mb-0">Perbarui status pemasangan</p>
                                </div>
                            </div>
                            <a href="{{ route('teknisi.status') }}" class="btn btn-warning btn-sm w-100 mt-auto">
                                <i class="bi bi-pencil-square me-1"></i>Update Status
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Kirim Laporan --}}
                <div class="col-md-4">
                    <div class="menu-card h-100 shadow-sm border-0">
                        <div class="menu-content">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle-md bg-success bg-opacity-10 me-3">
                                    <i class="bi bi-send text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="menu-title mb-1">Kirim Laporan</h6>
                                    <p class="menu-desc mb-0">Kirim laporan instalasi</p>
                                </div>
                            </div>
                            <a href="{{ route('teknisi.laporan.store') }}" class="btn btn-success btn-sm w-100 mt-auto">
                                <i class="bi bi-file-earmark-arrow-up me-1"></i>Kirim Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info Section --}}
            <div class="row mt-3">
                <div class="col-12">
                    <div class="info-card-md shadow-sm border-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle-md bg-dark bg-opacity-10 me-3">
                                <i class="bi bi-info-circle-fill text-dark fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">Informasi Penting</h6>
                                <p class="mb-0 text-muted">Pastikan untuk selalu update status instalasi dan kirim laporan setelah pekerjaan selesai.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats Section --}}
            <div class="row mt-3">
                <div class="col-md-4 mb-3">
                    <div class="stat-card-md bg-white border-0 shadow-sm p-3 rounded-3">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon-md bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="bi bi-clipboard-check text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Tugas Bulan Ini</h6>
                                <h5 class="mb-0 fw-bold">24</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-card-md bg-white border-0 shadow-sm p-3 rounded-3">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon-md bg-success bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Selesai</h6>
                                <h5 class="mb-0 fw-bold">18</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-card-md bg-white border-0 shadow-sm p-3 rounded-3">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon-md bg-warning bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="bi bi-clock-history text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Dalam Proses</h6>
                                <h5 class="mb-0 fw-bold">6</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Menu Card */
    .menu-card {
        background: white;
        border-radius: 10px;
        padding: 1.25rem;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .menu-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
    }

    .menu-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #4e73df, #1cc88a);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .menu-card:hover::before {
        transform: scaleX(1);
    }

    .menu-content {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .menu-title {
        font-size: 1rem;
        font-weight: 700;
        color: #2c3e50;
    }

    .menu-desc {
        font-size: 0.85rem;
        color: #6c757d;
    }

    /* Icon Circle */
    .icon-circle-md {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .menu-card:hover .icon-circle-md {
        transform: scale(1.1);
    }

    /* Buttons */
    .btn {
        font-weight: 600;
        border-radius: 6px;
        transition: all 0.2s ease;
        font-size: 0.8rem;
        padding: 0.5rem 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.75rem;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    }

    .btn-primary {
        background: #4e73df;
        border-color: #4e73df;
    }

    .btn-primary:hover {
        background: #2e59d9;
        border-color: #2e59d9;
    }

    .btn-info {
        background: #36b9cc;
        border-color: #36b9cc;
        color: #fff;
    }

    .btn-info:hover {
        background: #2c9faf;
        border-color: #2c9faf;
        color: #fff;
    }

    .btn-outline-info {
        color: #36b9cc;
        border-color: #36b9cc;
    }

    .btn-outline-info:hover {
        background: #36b9cc;
        color: #fff;
    }

    .btn-warning {
        background: #f6c23e;
        border-color: #f6c23e;
        color: #fff;
    }

    .btn-warning:hover {
        background: #f4b619;
        border-color: #f4b619;
        color: #fff;
    }

    .btn-success {
        background: #1cc88a;
        border-color: #1cc88a;
    }

    .btn-success:hover {
        background: #17a673;
        border-color: #17a673;
    }

    /* Info Card */
    .info-card-md {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
        padding: 1.25rem;
        border-left: 3px solid #212529;
    }

    /* Stat Card */
    .stat-card-md {
        transition: all 0.3s ease;
    }

    .stat-card-md:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1) !important;
    }

    .stat-icon-md {
        transition: all 0.3s ease;
    }

    .stat-card-md:hover .stat-icon-md {
        transform: scale(1.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .menu-card {
            padding: 1rem;
        }

        .menu-title {
            font-size: 0.9rem;
        }

        .menu-desc {
            font-size: 0.8rem;
        }

        .fs-4 {
            font-size: 1.25rem !important;
        }

        .icon-circle-md {
            width: 45px;
            height: 45px;
        }
    }

    @media (max-width: 576px) {
        .col-md-4 {
            margin-bottom: 0.75rem;
        }

        .stat-card-md {
            margin-bottom: 0.75rem;
        }
    }
</style>
@endsection