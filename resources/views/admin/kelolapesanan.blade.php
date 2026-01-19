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
    
    .number-badge {
        background-color: #0066cc;
        color: white;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    /* Status Badge Styles - Enhanced with Better Colors */
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
        background-color: #fef3c7;
        color: #92400e;
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
    
    .status-menunggu_verifikasi {
        background-color: #f3f4f6;
        color: #374151;
    }
    
    .status-lunas {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-siap_instalasi {
        background-color: #e0e7ff;
        color: #3730a3;
    }
    
    .status-selesai {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-ditolak_survei {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    /* Action Buttons with Icons */
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }
</style>

<div class="container-fluid p-0">
    <!-- Alert Notification -->
    @if(session('success'))
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
                        <i class="fas fa-clipboard-list me-3"></i>Kelola Pesanan WiFi
                    </h2>
                    <p class="mb-0 opacity-90">Manajemen Pesanan Pelanggan</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-list me-1"></i>
                            {{ $pesanan->count() }} Pesanan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Data Table with Card Wrapper -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>Pelanggan</th>
                                <th>Paket</th>
                                <th>Status</th>
                                <th>Teknisi</th>
                                <th>Laporan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan as $p)
                            <tr>
                                <td>
                                    <span class="number-badge">{{ $pesanan->firstItem() + $loop->index }}</span>
                                </td>
                                <td>{{ $p->pelanggan->nama ?? 'Nama tidak ditemukan' }}</td>
                                <td>{{ $p->paket->nama_paket ?? 'Nama tidak ditemukan'}}</td>

                                <!-- STATUS - ENHANCED WITH ICONS AND BETTER COLORS -->
                                <td>
                                    @if($p->status == 'pending')
                                        <span class="status-badge status-pending">
                                            <i class="fas fa-clock"></i>
                                            Pending
                                        </span>
                                    @elseif($p->status == 'menunggu_survei')
                                        <span class="status-badge status-menunggu_survei">
                                            <i class="fas fa-search"></i>
                                            Menunggu Survei
                                        </span>
                                    @elseif($p->status == 'survei_selesai')
                                        <span class="status-badge status-survei_selesai">
                                            <i class="fas fa-check-circle"></i>
                                            Survei Selesai
                                        </span>
                                    @elseif($p->status == 'menunggu_pembayaran')
                                        <span class="status-badge status-menunggu_pembayaran">
                                            <i class="fas fa-money-bill-wave"></i>
                                            Menunggu Pembayaran
                                        </span>
                                    @elseif($p->status == 'menunggu_verifikasi')
                                        <span class="status-badge status-menunggu_verifikasi">
                                            <i class="fas fa-hourglass-half"></i>
                                            Menunggu Verifikasi
                                        </span>
                                    @elseif($p->status == 'lunas')
                                        <span class="status-badge status-lunas">
                                            <i class="fas fa-check-double"></i>
                                            Lunas
                                        </span>
                                    @elseif($p->status == 'siap_instalasi')
                                        <span class="status-badge status-siap_instalasi">
                                            <i class="fas fa-tools"></i>
                                            Siap Instalasi
                                        </span>
                                    @elseif($p->status == 'selesai')
                                        <span class="status-badge status-selesai">
                                            <i class="fas fa-check-circle"></i>
                                            Selesai
                                        </span>
                                    @else
                                        <span class="status-badge status-ditolak_survei">
                                            <i class="fas fa-times-circle"></i>
                                            {{ str_replace('_',' ', ucfirst($p->status)) }}
                                        </span>
                                    @endif
                                </td>

                                <!-- TEKNISI - TIDAK DIUBAH -->
                                <td>
                                    @if($p->teknisi)
                                        {{ $p->teknisi->nama }}
                                    @else
                                        <span class="text-muted">Belum ada</span>
                                    @endif
                                </td>

                                <!-- LAPORAN - ENHANCED WITH ICONS -->
                                <td>
                                    @if($p->status == 'ditolak_survei')
                                        <span class="text-danger">
                                            <i class="fas fa-times-circle me-1"></i>
                                            Ditolak: {{ $p->alasan_penolakan ?? '-' }}
                                        </span>
                                    @elseif($p->laporan_teknisi)
                                        <span class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>
                                            {{ $p->laporan_teknisi }}
                                        </span>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-minus-circle me-1"></i>
                                            -
                                        </span>
                                    @endif
                                </td>

                                <!-- AKSI - WITH ICONS -->
                                <td>
                                    <div class="action-buttons">
                                        <!-- 1. PENDING → Atur Survei -->
                                        @if($p->status == 'pending')
                                            <button class="btn btn-primary btn-sm btn-action"
                                                data-bs-toggle="modal"
                                                data-bs-target="#surveiModal{{ $p->id }}"
                                                title="Atur Survei">
                                                <i class="fas fa-calendar-alt me-1"></i> Survei
                                            </button>

                                        <!-- 2. MENUNGGU SURVEI -->
                                        @elseif($p->status == 'menunggu_survei')
                                            <span class="text-muted">
                                                <i class="fas fa-spinner fa-spin me-1"></i>
                                                Menunggu survei teknisi...
                                            </span>

                                        <!-- 3. SURVEI SELESAI -->
                                        @elseif($p->status == 'survei_selesai')
                                            <span class="text-muted">
                                                <i class="fas fa-hourglass-half me-1"></i>
                                                Menunggu tagihan payment...
                                            </span>

                                        <!-- 4. MENUNGGU PEMBAYARAN -->
                                        @elseif($p->status == 'menunggu_pembayaran')
                                            <span class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                Menunggu bukti bayar...
                                            </span>

                                        <!-- 5. LUNAS = atur instalasi -->
                                        @elseif(in_array($p->status, ['lunas','siap_instalasi']))
                                            <button class="btn btn-primary btn-sm btn-action"
                                                data-bs-toggle="modal"
                                                data-bs-target="#instalasiModal{{ $p->id }}"
                                                title="Atur Instalasi">
                                                <i class="fas fa-tools me-1"></i> Instalasi
                                            </button>

                                        <!-- 6. SELESAI -->
                                        @elseif($p->status == 'selesai')
                                            <span class="text-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                Selesai
                                            </span>
                                        @endif

                                        <!-- Tombol DETAIL -->
                                        <button class="btn btn-secondary btn-sm btn-action"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $p->id }}"
                                            title="Detail">
                                            <i class="fas fa-info-circle me-1"></i> Detail
                                        </button>

                                        <button class="btn btn-warning btn-sm btn-action" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editJadwalSurvei{{ $p->id }}"
                                            title="Edit">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </button>
                                        
                                        <button class="btn btn-danger btn-sm btn-action"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalHapus{{ $p->id }}"
                                            title="Hapus">
                                            <i class="fas fa-trash me-1"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($pesanan->hasPages())
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-center">
                    {{ $pesanan->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- SEMUA MODAL DILETAKKAN DI LUAR TABLE -->
@foreach($pesanan as $p)
<!-- Modal Edit Jadwal Survei -->
<div class="modal fade" id="editJadwalSurvei{{ $p->id }}">
    <div class="modal-dialog">
        <form action="{{ route('pesanan.jadwalSurvei.update', $p->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Jadwal Survei
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Survei</label>
                        <input type="datetime-local" name="jadwal_survei"
                            value="{{ $p->jadwal_survei ? date('Y-m-d\TH:i', strtotime($p->jadwal_survei)) : '' }}"
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Teknisi</label>
                        <select name="teknisi_id" class="form-select">
                            @foreach ($teknisi as $t)
                                <option value="{{ $t->id }}" {{ $p->teknisi_id == $t->id ? 'selected' : '' }}>
                                    {{ $t->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Atur Survei -->
<div class="modal fade" id="surveiModal{{ $p->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.pesanan.jadwalSurvei', $p->id) }}" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-calendar-alt me-2"></i>Atur Jadwal Survei
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Pilih Teknisi</label>
                        <select name="teknisi_id" class="form-select" required>
                            <option value="">-- Pilih Teknisi --</option>
                            @foreach($teknisi as $t)
                                <option value="{{ $t->id }}">{{ $t->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Survei</label>
                        <input type="datetime-local" name="jadwal_survei" class="form-control" required>
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
            </div>
        </form>
    </div>
</div>

<!-- Modal Atur Instalasi -->
<div class="modal fade" id="instalasiModal{{ $p->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.pesanan.jadwalInstalasi', $p->id) }}" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-tools me-2"></i>Atur Jadwal Instalasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Pilih Teknisi</label>
                        <select name="teknisi_id" class="form-select" required>
                            <option value="">-- Pilih Teknisi --</option>
                            @foreach($teknisi as $t)
                                <option value="{{ $t->id }}" {{ $p->teknisi_id == $t->id ? 'selected' : '' }}>
                                    {{ $t->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Instalasi</label>
                        <input type="datetime-local" name="jadwal_instalasi" 
                            value="{{ $p->jadwal_instalasi ? date('Y-m-d\TH:i', strtotime($p->jadwal_instalasi)) : '' }}" 
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan (opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3">{{ $p->catatan ?? '' }}</textarea>
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
            </div>
        </form>
    </div>
</div>

<!-- Modal Detail Pesanan -->
<div class="modal fade" id="detailModal{{ $p->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2"></i>Detail Pesanan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <p><b>Pelanggan:</b> {{ $p->pelanggan->nama ?? '-' }}</p>
                        <p><b>Paket:</b> {{ $p->paket->nama_paket }}</p>
                        <p><b>Status:</b> 
                            @if($p->status == 'pending')
                                <span class="status-badge status-pending">
                                    <i class="fas fa-clock"></i>
                                    Pending
                                </span>
                            @elseif($p->status == 'menunggu_survei')
                                <span class="status-badge status-menunggu_survei">
                                    <i class="fas fa-search"></i>
                                    Menunggu Survei
                                </span>
                            @elseif($p->status == 'survei_selesai')
                                <span class="status-badge status-survei_selesai">
                                    <i class="fas fa-check-circle"></i>
                                    Survei Selesai
                                </span>
                            @elseif($p->status == 'menunggu_pembayaran')
                                <span class="status-badge status-menunggu_pembayaran">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Menunggu Pembayaran
                                </span>
                            @elseif($p->status == 'menunggu_verifikasi')
                                <span class="status-badge status-menunggu_verifikasi">
                                    <i class="fas fa-hourglass-half"></i>
                                    Menunggu Verifikasi
                                </span>
                            @elseif($p->status == 'lunas')
                                <span class="status-badge status-lunas">
                                    <i class="fas fa-check-double"></i>
                                    Lunas
                                </span>
                            @elseif($p->status == 'siap_instalasi')
                                <span class="status-badge status-siap_instalasi">
                                    <i class="fas fa-tools"></i>
                                    Siap Instalasi
                                </span>
                            @elseif($p->status == 'selesai')
                                <span class="status-badge status-selesai">
                                    <i class="fas fa-check-circle"></i>
                                    Selesai
                                </span>
                            @else
                                <span class="status-badge status-ditolak_survei">
                                    <i class="fas fa-times-circle"></i>
                                    {{ str_replace('_',' ', ucfirst($p->status)) }}
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Teknisi:</b>
                            @if($p->teknisi)
                                {{ $p->teknisi->nama }}
                            @else
                                <span class="text-muted">Belum dipilih</span>
                            @endif
                        </p>
                        <p><b>Jadwal Survei:</b>
                            @if($p->jadwal_survei)
                                {{ $p->jadwal_survei }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </p>
                    </div>
                </div>

                <hr>

                <!-- LAPORAN DI DETAIL - DENGAN IKON -->
                <p><b>Laporan Teknisi:</b>
                    @if($p->status == 'ditolak_survei')
                        <span class="text-danger">
                            <i class="fas fa-times-circle me-1"></i>
                            Ditolak: {{ $p->alasan_penolakan }}
                        </span>
                    @elseif($p->laporan_teknisi)
                        <span class="text-success">
                            <i class="fas fa-check-circle me-1"></i>
                            {{ $p->laporan_teknisi }}
                        </span>
                    @else
                        <span class="text-muted">
                            <i class="fas fa-minus-circle me-1"></i>
                            Belum ada laporan
                        </span>
                    @endif
                </p>

                <hr>

                <p><b>Koordinat Lokasi:</b></p>
                <p>
                    <b>Latitude:</b>
                    @if($p->latitude)
                        {{ $p->latitude }}
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </p>
                <p>
                    <b>Longitude:</b>
                    @if($p->longitude)
                        {{ $p->longitude }}
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </p>

                @if($p->latitude && $p->longitude)
                    <a href="https://www.google.com/maps?q={{ $p->latitude }},{{ $p->longitude }}" 
                       target="_blank"
                       class="btn btn-sm btn-outline-primary mt-2">
                        <i class="fas fa-map-marked-alt me-1"></i>
                        Lihat di Google Maps
                    </a>
                @endif
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus{{ $p->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content"
              method="POST"
              action="{{ route('pesanan.delete', $p->id) }}">
            @csrf
            @method('DELETE')

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Hapus Pesanan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center p-4">
                <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                <h5>Apakah Anda yakin?</h5>
                <p class="text-muted">Anda akan menghapus pesanan <strong>{{ $p->pelanggan->nama ?? '-' }}</strong>?</p>
                <p class="text-danger small">⚠️ Tindakan ini tidak dapat dibatalkan!</p>
            </div>

            <div class="modal-footer bg-light">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button class="btn btn-danger">
                    <i class="fas fa-trash me-1"></i> Hapus
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection