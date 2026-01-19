@extends('layout.app')

@section('content')
<style>
    /* Clean Blue Theme */
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
    
    .icon-preview {
        border-radius: 8px;
        padding: 4px;
        background-color: #f8fafc;
        transition: transform 0.2s ease;
    }
    
    .icon-preview:hover {
        transform: scale(1.05);
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
    
    .payment-code {
        background-color: #f1f5f9;
        padding: 6px 12px;
        border-radius: 6px;
        font-family: 'Courier New', monospace;
        font-size: 0.875rem;
        color: #475569;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-wallet me-3"></i>Kelola Metode Pembayaran
                    </h2>
                    <p class="mb-0 opacity-90">Kelola semua metode pembayaran yang tersedia</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Metode
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Search Section -->
        <div class="card mb-4">
            <div class="card-body p-4">
                <form action="{{ route('superadmin.metodepembayaran') }}" method="GET">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="search-box">
                                <input 
                                    type="text" 
                                    name="search" 
                                    class="form-control form-control-lg"
                                    placeholder="Cari nama metode atau nomor pembayaran..."
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

        <!-- Data Table -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th width="100">Icon</th>
                                <th>Metode Pembayaran</th>
                                <th>Nomor</th>
                                <th>Deskripsi</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $m)
                            <tr>
                                <td>
                                    <span class="number-badge">{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    @if($m->icon)
                                        <img src="{{ asset('storage/' . $m->icon) }}" width="60" class="rounded icon-preview">
                                    @else
                                        <div class="text-center">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $m->nama_metode }}</strong>
                                </td>
                                <td>
                                    <code class="payment-code">{{ $m->nomor_pembayaran }}</code>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $m->deskripsi ?? '-' }}</small>
                                </td>
                                <td>
                                    <button class="btn btn-action btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $m->id }}">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <button class="btn btn-action btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalHapus{{ $m->id }}">
                                        <i class="fas fa-trash me-1"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">📭</div>
                                        <h5>Belum Ada Data</h5>
                                        <p>Metode pembayaran belum ditambahkan</p>
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

{{-- =========================== --}}
{{--     MODAL TAMBAH DATA        --}}
{{-- =========================== --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST"
              action="{{ route('superadmin.metodepembayaran.store') }}"
              enctype="multipart/form-data"
              class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Metode Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Metode</label>
                            <input type="text" name="nama_metode" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nomor Pembayaran</label>
                            <input type="text" name="nomor_pembayaran" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Icon Metode</label>
                    <input type="file" name="icon" class="form-control" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, SVG (Max: 2MB)</small>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- =========================== --}}
{{--     MODAL EDIT DATA          --}}
{{-- =========================== --}}
@foreach ($data as $m)
<div class="modal fade" id="modalEdit{{ $m->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST"
            action="{{ route('superadmin.metodepembayaran.update', $m->id) }}"
            enctype="multipart/form-data"
            class="modal-content">

            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Metode Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Metode</label>
                            <input type="text" name="nama_metode" class="form-control" value="{{ $m->nama_metode }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nomor Pembayaran</label>
                            <input type="text" name="nomor_pembayaran" class="form-control" value="{{ $m->nomor_pembayaran }}" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ $m->deskripsi }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Icon Baru</label>
                    <input type="file" name="icon" class="form-control" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah</small>
                    @if($m->icon)
                        <div class="mt-2">
                            <small class="text-muted">Icon saat ini:</small>
                            <br>
                            <img src="{{ asset('storage/' . $m->icon) }}" width="60" class="rounded icon-preview">
                        </div>
                    @endif
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-sync me-1"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- =========================== --}}
{{--         MODAL HAPUS         --}}
{{-- =========================== --}}
@foreach ($data as $m)
<div class="modal fade" id="modalHapus{{ $m->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST"
              action="{{ url('superadmin/metodepembayaran/delete/' . $m->id) }}"
              class="modal-content">
            @csrf
            @method('DELETE')

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center p-4">
                <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                <h5>Apakah Anda yakin?</h5>
                <p class="text-muted">Anda akan menghapus <strong>"{{ $m->nama_metode }}"</strong></p>
                <p class="text-danger small">Tindakan ini tidak dapat dibatalkan</p>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash me-1"></i> Hapus
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection