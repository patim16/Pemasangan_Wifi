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
    
    .schedule-card {
        border: 1px solid #e3e8f0;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .schedule-card:hover {
        transform: translateY(-5px);
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
        color: white;
        padding: 25px;
        border: none;
    }
    
    .card-header-custom h5 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .card-header-custom h5 i {
        margin-right: 10px;
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
    
    .id-badge {
        background-color: #0066cc;
        color: white;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 0.875rem;
        font-weight: 600;
        font-family: monospace;
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
    
    .status-jadwal-instalasi {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .btn-action {
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.875rem;
        margin: 0 2px;
        transition: all 0.2s ease;
    }
    
    .btn-outline-primary {
        border-color: #0066cc;
        color: #0066cc;
    }
    
    .btn-outline-primary:hover {
        background-color: #0066cc;
        border-color: #0066cc;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 102, 204, 0.2);
    }
    
    .btn-primary {
        background-color: #0066cc;
        border-color: #0066cc;
    }
    
    .btn-primary:hover {
        background-color: #0052a3;
        border-color: #0052a3;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 102, 204, 0.2);
    }
    
    .btn-success {
        background-color: #10b981;
        border-color: #10b981;
    }
    
    .btn-success:hover {
        background-color: #059669;
        border-color: #059669;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
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
    
    .modal-footer {
        background-color: #f8fafc;
        border-top: none;
    }
    
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 6px;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-tools me-3"></i>Jadwal Instalasi
                    </h2>
                    <p class="mb-0 opacity-90">Daftar jadwal instalasi yang dikirim admin</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-list me-1"></i>
                            {{ $pemasangan->count() }} Jadwal
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="container">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="container">
        <div class="schedule-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Pelanggan</th>
                            <th>Alamat</th>
                            <th>Paket</th>
                            <th>Tanggal Instalasi</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pemasangan as $item)
                        <tr>
                            <td>
                                <span class="id-badge">{{ $item->invoice_code }}</span>
                            </td>

                            <td>
                                @if ($item->pelanggan)
                                    <strong>{{ $item->pelanggan->nama ?? '-' }}</strong><br>
                                    <small class="text-muted">
                                        <i class="fas fa-phone me-1"></i>
                                        {{ $item->pelanggan->no_hp ?? '-' }}
                                    </small>
                                @else
                                    <span class="text-danger">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        Pelanggan tidak ditemukan
                                    </span>
                                @endif
                            </td>

                            <td>
                                <span class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $item->pelanggan->alamat ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-wifi me-1"></i>
                                    {{ $item->paket->nama_paket ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($item->jadwal_instalasi)->format('d M Y H:i') }}
                                </span>
                            </td>

                            {{-- STATUS + SELESAI --}}
                            <td>
                                <span class="status-badge status-jadwal-instalasi">
                                    <i class="fas fa-calendar-check"></i>
                                    Jadwal Instalasi
                                </span>

                                <form action="{{ route('teknisi.instalasi.selesai', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin instalasi sudah selesai?')"
                                      class="mt-2">
                                    @csrf
                                    <button class="btn btn-success btn-sm w-100">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Selesai Instalasi
                                    </button>
                                </form>
                            </td>

                            {{-- AKSI --}}
                            <td class="text-center">
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-outline-primary btn-action"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $item->id }}"
                                            title="Detail">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📅</div>
                                    <h5>Belum Ada Jadwal Instalasi</h5>
                                    <p>Belum ada jadwal instalasi dari admin</p>
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

{{-- ================= MODAL DETAIL - DIPINDAH KE LUAR TABEL ================= --}}
@foreach ($pemasangan as $item)
<div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2"></i>
                    Detail Instalasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted">Invoice</h6>
                            <p class="mb-0 fw-semibold">{{ $item->invoice_code }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">Pelanggan</h6>
                            <p class="mb-0 fw-semibold">{{ $item->pelanggan->nama ?? '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">No HP</h6>
                            <p class="mb-0">{{ $item->pelanggan->no_hp ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted">Alamat</h6>
                            <p class="mb-0">{{ $item->pelanggan->alamat ?? '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">Paket</h6>
                            <p class="mb-0">{{ $item->paket->nama_paket ?? '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">Tanggal Instalasi</h6>
                            <p class="mb-0">
                                {{ \Carbon\Carbon::parse($item->jadwal_instalasi)->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <h6 class="text-muted">Status</h6>
                    <span class="status-badge status-jadwal-instalasi">
                        <i class="fas fa-calendar-check"></i>
                        Jadwal Instalasi
                    </span>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection