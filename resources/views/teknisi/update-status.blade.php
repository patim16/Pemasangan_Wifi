@extends('layout.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3">
    <div class="row">
        <div class="col-12">
            
            {{-- Header Section --}}
            <div class="mb-3">
                <h5 class="fw-bold mb-1 text-dark fs-4">Update Status Pemasangan</h5>
                <p class="text-muted mb-0" style="font-size: 0.8rem;">Kelola dan update status instalasi WiFi pelanggan</p>
            </div>

            {{-- Alert Success --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Form untuk Update --}}
            <form action="{{ route('teknisi.status.update') }}" method="POST">
                @csrf

                {{-- Daftar Instalasi Card --}}
                <div class="dashboard-card mb-3">
                    <div class="card-header-custom">
                        <h6 class="mb-0 fw-bold">Daftar Instalasi</h6>
                        <span class="badge bg-primary" style="font-size: 0.75rem;">{{ count($instalasi) }} Data</span>
                    </div>
                    <div class="card-body-custom">
                        <div class="table-responsive">
                            <table class="simple-table">
                                <thead>
                                    <tr>
                                        <th style="width: 100px;">No</th>
                                        <th>Alamat Instalasi</th>
                                        <th style="width: 200px;" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($instalasi as $item)
                                    <tr>
                                        <td>
                                            <span class="text-primary fw-semibold">#{{ $item->id }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $item->alamat }}</div>
                                            @if($item->nama_pelanggan)
                                                <small class="text-muted">
                                                    <i class="bi bi-person-fill me-1"></i>{{ $item->nama_pelanggan }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                @if($item->status == 'proses')
                                                    <span class="status-badge status-warning">
                                                        <i class="bi bi-hourglass-split"></i>
                                                        <span>Proses</span>
                                                    </span>
                                                @elseif($item->status == 'selesai')
                                                    <span class="status-badge status-success">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                        <span>Selesai</span>
                                                    </span>
                                                @elseif($item->status == 'menunggu')
                                                    <span class="status-badge status-secondary">
                                                        <i class="bi bi-clock-fill"></i>
                                                        <span>Menunggu</span>
                                                    </span>
                                                @else
                                                    <span class="status-badge status-danger">
                                                        <i class="bi bi-x-circle-fill"></i>
                                                        <span>{{ ucfirst($item->status) }}</span>
                                                    </span>
                                                @endif
                                                
                                                <a href="{{ route('teknisi.instalasi.detail', $item->id) }}" 
                                                    class="btn-detail-link">
                                                        <i class="bi bi-info-circle-fill me-1"></i>
                                                        Detail Data
                                                </a>

                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Modal Detail --}}
                                    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg">
                                                <div class="modal-header bg-primary text-white border-0">
                                                    <h5 class="modal-title fw-bold mb-0">
                                                        <i class="bi bi-file-text-fill me-2"></i>
                                                        Detail Instalasi #{{ $item->id }}
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="detail-item">
                                                        <div class="detail-label">
                                                            <i class="bi bi-hash text-primary"></i>
                                                            <span>Nomor</span>
                                                        </div>
                                                        <div class="detail-value">#{{ $item->id }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-label">
                                                            <i class="bi bi-person-fill text-primary"></i>
                                                            <span>Pelanggan</span>
                                                        </div>
                                                        <div class="detail-value">{{ $item->nama_pelanggan ?? '-' }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-label">
                                                            <i class="bi bi-geo-alt-fill text-primary"></i>
                                                            <span>Alamat</span>
                                                        </div>
                                                        <div class="detail-value">{{ $item->alamat }}</div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-label">
                                                            <i class="bi bi-info-circle-fill text-primary"></i>
                                                            <span>Status</span>
                                                        </div>
                                                        <div class="detail-value">
                                                            <span class="badge bg-{{ $item->status == 'selesai' ? 'success' : ($item->status == 'proses' ? 'warning' : 'secondary') }}">
                                                                {{ ucfirst($item->status) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="detail-item">
                                                        <div class="detail-label">
                                                            <i class="bi bi-calendar-fill text-primary"></i>
                                                            <span>Tanggal</span>
                                                        </div>
                                                        <div class="detail-value">{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '-' }}</div>
                                                    </div>
                                                    <div class="detail-item mb-0">
                                                        <div class="detail-label">
                                                            <i class="bi bi-chat-left-text-fill text-primary"></i>
                                                            <span>Catatan</span>
                                                        </div>
                                                        <div class="detail-value">{{ $item->catatan ?? '-' }}</div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 bg-light">
                                                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                                        <i class="bi bi-x-circle me-1"></i>Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="bi bi-inbox"></i>
                                                <p>Tidak ada data instalasi</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Notifikasi Card --}}
                <div class="dashboard-card mb-3">
                    <div class="card-header-custom">
                        <h6 class="mb-0 fw-bold">Notifikasi Ke Konsumen</h6>
                    </div>
                    <div class="card-body-custom">
                        <div class="notification-box">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="kirim_notifikasi" id="kirimNotifikasi" value="1">
                                <label class="form-check-label" for="kirimNotifikasi">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-envelope-fill text-warning me-2" style="font-size: 1.1rem;"></i>
                                        <div>
                                            <div class="fw-semibold" style="font-size: 0.9rem;">Kirim notifikasi setelah update</div>
                                            <small class="text-muted" style="font-size: 0.75rem;">Konsumen akan menerima pemberitahuan melalui email atau SMS</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle me-1"></i>Update Status
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
    /* Dashboard Card */
    .dashboard-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid #e3e6f0;
    }

    .card-header-custom {
        padding: 0.875rem 1rem;
        background: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-body-custom {
        padding: 1rem;
    }

    /* Simple Table */
    .simple-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #e3e6f0;
    }

    .simple-table thead th {
        background: white;
        color: #5a5c69;
        font-weight: 600;
        padding: 0.625rem 0.75rem;
        font-size: 0.8rem;
        text-transform: uppercase;
        border-bottom: 2px solid #e3e6f0;
        border-right: 1px solid #e3e6f0;
        text-align: left;
    }

    .simple-table thead th:last-child {
        border-right: none;
    }

    .simple-table tbody td {
        padding: 0.625rem 0.75rem;
        border-bottom: 1px solid #e3e6f0;
        border-right: 1px solid #e3e6f0;
        vertical-align: middle;
        background: white;
        font-size: 0.85rem;
    }

    .simple-table tbody td:last-child {
        border-right: none;
    }

    .simple-table tbody tr:hover td {
        background: #f8f9fc;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.35rem 0.7rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.7rem;
    }

    .status-warning {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffc107;
    }

    .status-success {
        background: #d1e7dd;
        color: #0f5132;
        border: 1px solid #198754;
    }

    .status-secondary {
        background: #e2e3e5;
        color: #41464b;
        border: 1px solid #6c757d;
    }

    .status-danger {
        background: #f8d7da;
        color: #842029;
        border: 1px solid #dc3545;
    }

    /* Button Detail Link */
    .btn-detail-link {
        background: transparent;
        border: none;
        color: #4e73df;
        font-weight: 600;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        padding: 0;
        text-decoration: none;
    }

    .btn-detail-link:hover {
        color: #2e59d9;
        text-decoration: underline;
    }

    .btn-detail-link i {
        font-size: 0.9rem;
    }

    /* Detail Items */
    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e3e6f0;
    }

    .detail-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .detail-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: #5a5c69;
    }

    .detail-value {
        font-weight: 500;
        color: #3a3b45;
        text-align: right;
    }

    /* Notification Box */
    .notification-box {
        padding: 1rem;
        background: #fff9e6;
        border: 2px dashed #ffc107;
        border-radius: 8px;
    }

    .form-check-input:checked {
        background-color: #4e73df;
        border-color: #4e73df;
    }

    .form-check-input {
        width: 2.5rem;
        height: 1.3rem;
        cursor: pointer;
    }

    .form-check-label {
        cursor: pointer;
        margin-left: 0.5rem;
    }

    /* Empty State */
    .empty-state {
        color: #adb5bd;
    }

    .empty-state i {
        font-size: 2.5rem;
        display: block;
        margin-bottom: 0.5rem;
        opacity: 0.5;
    }

    .empty-state p {
        font-size: 0.9rem;
        margin: 0;
    }

    /* Buttons */
    .btn {
        font-weight: 600;
        border-radius: 6px;
        transition: all 0.2s;
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
    }

    .btn-primary {
        background: #4e73df;
        border-color: #4e73df;
    }

    .btn-primary:hover {
        background: #2e59d9;
        border-color: #2e59d9;
        transform: translateY(-1px);
    }

    .btn-outline-secondary {
        border-color: #858796;
        color: #858796;
    }

    .btn-outline-secondary:hover {
        background: #858796;
        border-color: #858796;
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-header-custom {
            padding: 0.875rem 1rem;
        }

        .card-body-custom {
            padding: 1rem;
        }

        .simple-table thead th,
        .simple-table tbody td {
            padding: 0.625rem;
            font-size: 0.85rem;
        }

        .status-badge {
            padding: 0.35rem 0.7rem;
            font-size: 0.7rem;
        }

        .d-flex.gap-2 {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endsection