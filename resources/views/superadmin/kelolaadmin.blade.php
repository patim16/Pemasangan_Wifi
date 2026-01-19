@extends('layout.app')

@section('content')
<style>
    /* Clean Blue Theme - Same as Metode Pembayaran */
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
    
    .avatar-circle {
        border-radius: 50%;
        width: 42px;
        height: 42px;
        background-color: #0066cc;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-right: 12px;
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
    
    .info-badge {
        background-color: #f1f5f9;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.875rem;
        color: #475569;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Metode Pembayaran -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-users-cog me-3"></i>Kelola Admin
                    </h2>
                    <p class="mb-0 opacity-90">Manajemen Administrator Sistem</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#modalTambahAdmin">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Admin
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Search Section - Same Style -->
        <div class="card mb-4">
            <div class="card-body p-4">
                <form action="{{ route('superadmin.admin.index') }}" method="GET">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="search-box">
                                <input 
                                    type="text" 
                                    name="search" 
                                    class="form-control form-control-lg"
                                    placeholder="Cari nama atau email..."
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
                                <th>Informasi Admin</th>
                                <th>Kontak</th>
                                <th>Alamat</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($admins as $admin)
                            <tr>
                                <td>
                                    <span class="number-badge">{{ $admins->firstItem() + $loop->index }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle">
                                            {{ substr(strtoupper($admin->nama), 0, 1) }}
                                        </div>
                                        <div>
                                            <strong>{{ $admin->nama }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $admin->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-phone text-success me-2"></i>
                                        <span>{{ $admin->no_hp }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-map-marker-alt text-danger me-2 mt-1"></i>
                                        <span>{{ $admin->alamat }}</span>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-action btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditAdmin{{ $admin->id }}">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                    <form action="{{ route('superadmin.admin.delete', $admin->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-action btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">👥</div>
                                        <h5>Belum Ada Data</h5>
                                        <p>Administrator belum ditambahkan</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($admins->hasPages())
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between align-items-center py-2">
                    <small class="text-muted">
                        Menampilkan {{ $admins->firstItem() }} - {{ $admins->lastItem() }} dari total {{ $admins->total() }} data
                    </small>
                    <div>
                        {{ $admins->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- ====================================================== -->
<!-- MODAL TAMBAH ADMIN - Same Style as Metode Pembayaran    -->
<!-- ====================================================== -->
<div class="modal fade" id="modalTambahAdmin" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" action="{{ route('superadmin.admin.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Administrator
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" name="no_hp" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" rows="3" required></textarea>
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

<!-- ====================================================== -->
<!-- MODAL EDIT ADMIN - Same Style as Metode Pembayaran      -->
<!-- ====================================================== -->
@foreach($admins as $admin)
<div class="modal fade" id="modalEditAdmin{{ $admin->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" action="{{ route('superadmin.admin.update', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Administrator
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ $admin->nama }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $admin->email }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ $admin->no_hp }}" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" rows="3" required>{{ $admin->alamat }}</textarea>
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

@endsection