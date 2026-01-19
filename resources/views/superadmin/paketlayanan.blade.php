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
    
    .btn-primary {
        background-color: #0066cc;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        background-color: #0052a3;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 102, 204, 0.2);
    }
    
    .card {
        border: 1px solid #e3e8f0;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: box-shadow 0.2s ease;
    }
    
    .card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
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
    
    .btn-action {
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.875rem;
        margin: 0 2px;
        transition: all 0.2s ease;
    }
    
    .btn-warning {
        background-color: #f59e0b;
        border: none;
        color: white;
    }
    
    .btn-warning:hover {
        background-color: #d97706;
    }
    
    .btn-danger {
        background-color: #ef4444;
        border: none;
        color: white;
    }
    
    .btn-danger:hover {
        background-color: #dc2626;
    }
    
    .search-box {
        position: relative;
    }
    
    .search-box input {
        border-radius: 8px;
        padding-left: 45px;
        border: 1px solid #d1d5db;
        transition: border-color 0.2s ease;
    }
    
    .search-box input:focus {
        border-color: #0066cc;
        box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        outline: none;
    }
    
    .search-box::before {
        content: "🔍";
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
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
    
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #d1d5db;
        transition: border-color 0.2s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0066cc;
        box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        outline: none;
    }
    
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
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
    
    .number-badge {
        background-color: #0066cc;
        color: white;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    .price-badge {
        background-color: #f0fdf4;
        color: #16a34a;
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .speed-badge {
        background-color: #eff6ff;
        color: #2563eb;
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.875rem;
    }
</style>

<div class="container-fluid p-0">
    <!-- Alert Notification -->
    @if (session('success'))
        <div class="container">
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-wifi me-3"></i>Paket Layanan WiFi
                    </h2>
                    <p class="mb-0 opacity-90">Manajemen Paket Layanan Internet</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Paket
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Search Section - Same Style -->
        <div class="card mb-4">
            <div class="card-body p-4">
                <form action="{{ route('superadmin.paketlayanan') }}" method="GET">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="search-box">
                                <input 
                                    type="text" 
                                    name="search" 
                                    class="form-control form-control-lg"
                                    placeholder="Cari nama paket..."
                                    value="{{ request('search') }}"
                                >
                            </div>
                        </div>
                        <div class="col-md-4 mt-3 mt-md-0">
                            <button class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-search me-2"></i>Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table - Same Style -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>Nama Paket</th>
                                <th>Kecepatan</th>
                                <th>Harga</th>
                                <th>Biaya Pasang</th>
                                <th>Deskripsi</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pakets as $p)
                            <tr>
                                <td>
                                    <span class="number-badge">{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    <strong>{{ $p->nama_paket }}</strong>
                                </td>
                                <td>
                                    <span class="speed-badge">
                                        <i class="fas fa-tachometer-alt me-1"></i>
                                        {{ $p->kecepatan }} Mbps
                                    </span>
                                </td>
                                <td>
                                    <span class="price-badge">
                                        <i class="fas fa-tag me-1"></i>
                                        Rp {{ number_format($p->harga) }}
                                    </span>
                                </td>
                                <td>
    <span class="price-badge">
        Rp {{ number_format($p->biaya_pemasangan) }}
    </span>
</td>

                                <td>
                                    <small class="text-muted">{{ $p->deskripsi ?? '-' }}</small>
                                </td>
                                <td>
                                    <button class="btn btn-action btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $p->id }}">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <form action="/superadmin/paketlayanan/delete/{{ $p->id }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-action btn-danger"
                                                onclick="return confirm('Yakin hapus paket ini?')">
                                            <i class="fas fa-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">📦</div>
                                        <h5>Belum Ada Data</h5>
                                        <p>Paket layanan belum ditambahkan</p>
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

{{-- ================================================= --}}
{{--  MODAL TAMBAH PAKET - Same Style as Other Pages     --}}
{{-- ================================================= --}}
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/superadmin/paketlayanan/store" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Paket Layanan
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Paket</label>
                                <input type="text" name="nama_paket" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kecepatan (Mbps)</label>
                                <input type="number" name="kecepatan" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" name="harga" class="form-control" required>
                            </div>
                        </div>
                    </div>
                       
                     <div class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Biaya Pemasangan</label>
        <input type="number" name="biaya_pemasangan" class="form-control" value="0" required>
    </div>
</div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================================================= --}}
{{--  MODAL EDIT PAKET - Same Style as Other Pages        --}}
{{-- ================================================= --}}
@foreach ($pakets as $p)
<div class="modal fade" id="modalEdit{{ $p->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/superadmin/paketlayanan/update/{{ $p->id }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Paket Layanan
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Paket</label>
                                <input type="text" name="nama_paket" class="form-control"
                                       value="{{ $p->nama_paket }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kecepatan (Mbps)</label>
                                <input type="number" name="kecepatan" class="form-control"
                                       value="{{ $p->kecepatan }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" name="harga" class="form-control"
                                       value="{{ $p->harga }}" required>
                            </div>
                        </div>
                    </div>
                       
                     <div class="col-md-6">
    <div class="mb-3">
        <label class="form-label">Biaya Pemasangan</label>
        <input type="number"
               name="biaya_pemasangan"
               class="form-control"
               value="{{ $p->biaya_pemasangan }}"
               required>
    </div>
</div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3">{{ $p->deskripsi }}</textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button class="btn btn-warning">
                        <i class="fas fa-sync me-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection