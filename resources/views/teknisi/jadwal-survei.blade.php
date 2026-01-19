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
    
    .form-select, .form-control {
        border-radius: 8px;
        border: 1px solid #d1d5db;
        transition: border-color 0.2s ease;
    }
    
    .form-select:focus, .form-control:focus {
        border-color: #0066cc;
        box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        outline: none;
    }
    
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }
    
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 6px;
    }
    
    /* Pagination Styles - Diperbaiki */
    .pagination-container {
        padding: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .pagination {
        margin-bottom: 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .pagination .page-item {
        margin: 0 2px;
    }
    
    .pagination .page-item .page-link {
        color: #0066cc;
        border-color: #e3e8f0;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 0.875rem;
        min-width: 36px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 36px;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0066cc;
        border-color: #0066cc;
        color: white;
    }
    
    .pagination .page-item .page-link:hover {
        color: #0052a3;
        background-color: #f8fafc;
        border-color: #0066cc;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #fff;
        border-color: #dee2e6;
    }
    
    /* Menyembunyikan teks "Previous" dan "Next" dan mengganti dengan ikon */
    .pagination .page-item:first-child .page-link::before {
        content: "‹";
        font-weight: bold;
    }
    
    .pagination .page-item:last-child .page-link::before {
        content: "›";
        font-weight: bold;
    }
    
    .pagination .page-item:first-child .page-link span,
    .pagination .page-item:last-child .page-link span {
        display: none;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-calendar-alt me-3"></i>Jadwal Survei
                    </h2>
                    <p class="mb-0 opacity-90">Kelola jadwal survei untuk pelanggan</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-list me-1"></i>
                            {{ $pesanan->total() }} jadwal
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="schedule-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Alamat</th>
                            <th>Paket</th>
                            <th>Jadwal</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesanan as $item)
                        <tr>
                            <td>
                                <span class="id-badge">#SRV{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </td>

                            {{-- ================= PELANGGAN ================= --}}
                            <td>
                                @if ($item->pelanggan)
                                    @php
                                        $namaPelanggan = $item->pelanggan->nama
                                            ?? $item->pelanggan->name
                                            ?? '-';
                                    @endphp

                                    <strong>{{ $namaPelanggan }}</strong><br>
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

                            {{-- ================= ALAMAT ================= --}}
                            <td>
                                <span class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $item->alamat ?? '-' }}
                                </span>
                            </td>

                            {{-- ================= PAKET ================= --}}
                            <td>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-wifi me-1"></i>
                                    {{ $item->paket->nama_paket ?? '-' }}
                                </span>
                            </td>

                            {{-- ================= JADWAL ================= --}}
                            <td>
                                @if($item->jadwal_survei)
                                    <span class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($item->jadwal_survei)->format('d M Y H:i') }}
                                    </span>
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-minus-circle me-1"></i>
                                        -
                                    </span>
                                @endif
                            </td>

                            {{-- ================= STATUS ================= --}}
                            <td>
                                @if($item->status == 'pending')
                                    <span class="status-badge status-pending">
                                        <i class="fas fa-clock"></i>
                                        Pending
                                    </span>
                                @elseif($item->status == 'menunggu_survei')
                                    <span class="status-badge status-menunggu_survei">
                                        <i class="fas fa-search"></i>
                                        Menunggu Survei
                                    </span>
                                @elseif($item->status == 'survei_selesai')
                                    <span class="status-badge status-survei_selesai">
                                        <i class="fas fa-check-circle"></i>
                                        Survei Selesai
                                    </span>
                                @elseif($item->status == 'menunggu_pembayaran')
                                    <span class="status-badge status-menunggu_pembayaran">
                                        <i class="fas fa-money-bill-wave"></i>
                                        Menunggu Pembayaran
                                    </span>
                                @elseif($item->status == 'menunggu_verifikasi')
                                    <span class="status-badge status-menunggu_verifikasi">
                                        <i class="fas fa-hourglass-half"></i>
                                        Menunggu Verifikasi
                                    </span>
                                @elseif($item->status == 'lunas')
                                    <span class="status-badge status-lunas">
                                        <i class="fas fa-check-double"></i>
                                        Lunas
                                    </span>
                                @elseif($item->status == 'siap_instalasi')
                                    <span class="status-badge status-siap_instalasi">
                                        <i class="fas fa-tools"></i>
                                        Siap Instalasi
                                    </span>
                                @elseif($item->status == 'selesai')
                                    <span class="status-badge status-selesai">
                                        <i class="fas fa-check-circle"></i>
                                        Selesai
                                    </span>
                                @else
                                    <span class="status-badge">
                                        <i class="fas fa-info-circle"></i>
                                        {{ ucfirst(str_replace('_',' ', $item->status)) }}
                                    </span>
                                @endif
                            </td>

                            {{-- ================= AKSI ================= --}}
                            <td class="text-center">
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-outline-primary btn-action"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $item->id }}"
                                        title="Detail">
                                        <i class="fas fa-info-circle"></i>
                                    </button>

                                    <button class="btn btn-sm btn-primary btn-action"
                                        data-bs-toggle="modal"
                                        data-bs-target="#laporanModal{{ $item->id }}"
                                        title="Kirim Laporan">
                                        <i class="fas fa-file-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📅</div>
                                    <h5>Belum Ada Jadwal Survei</h5>
                                    <p>Tidak ada jadwal survei yang tersedia saat ini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($pesanan->hasPages())
            <div class="pagination-container">
                {{ $pesanan->links('pagination::bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ================= MODAL DETAIL - DIPINDAH KE LUAR TABEL ================= --}}
@foreach ($pesanan as $item)
<div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2"></i>
                    Detail Survei
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                @php
                    $namaPelanggan = $item->pelanggan->nama
                        ?? $item->pelanggan->name
                        ?? '-';
                @endphp

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted">Pelanggan</h6>
                            <p class="mb-0 fw-semibold">{{ $namaPelanggan }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">No HP</h6>
                            <p class="mb-0">{{ $item->pelanggan->no_hp ?? '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">Paket</h6>
                            <p class="mb-0">{{ $item->paket->nama_paket ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted">Alamat</h6>
                            <p class="mb-0">{{ $item->alamat ?? '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">Jadwal</h6>
                            <p class="mb-0">
                                {{ $item->jadwal_survei
                                    ? \Carbon\Carbon::parse($item->jadwal_survei)->format('d M Y H:i')
                                    : '-' }}
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-muted">Status</h6>
                            @if($item->status == 'pending')
                                <span class="status-badge status-pending">
                                    <i class="fas fa-clock"></i>
                                    Pending
                                </span>
                            @elseif($item->status == 'menunggu_survei')
                                <span class="status-badge status-menunggu_survei">
                                    <i class="fas fa-search"></i>
                                    Menunggu Survei
                                </span>
                            @elseif($item->status == 'survei_selesai')
                                <span class="status-badge status-survei_selesai">
                                    <i class="fas fa-check-circle"></i>
                                    Survei Selesai
                                </span>
                            @elseif($item->status == 'menunggu_pembayaran')
                                <span class="status-badge status-menunggu_pembayaran">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Menunggu Pembayaran
                                </span>
                            @elseif($item->status == 'menunggu_verifikasi')
                                <span class="status-badge status-menunggu_verifikasi">
                                    <i class="fas fa-hourglass-half"></i>
                                    Menunggu Verifikasi
                                </span>
                            @elseif($item->status == 'lunas')
                                <span class="status-badge status-lunas">
                                    <i class="fas fa-check-double"></i>
                                    Lunas
                                </span>
                            @elseif($item->status == 'siap_instalasi')
                                <span class="status-badge status-siap_instalasi">
                                    <i class="fas fa-tools"></i>
                                    Siap Instalasi
                                </span>
                            @elseif($item->status == 'selesai')
                                <span class="status-badge status-selesai">
                                    <i class="fas fa-check-circle"></i>
                                    Selesai
                                </span>
                            @else
                                <span class="status-badge">
                                    <i class="fas fa-info-circle"></i>
                                    {{ ucfirst(str_replace('_',' ', $item->status)) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <hr>

                {{-- ================= KOORDINAT ================= --}}
                <h6 class="text-muted">Koordinat Lokasi</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Latitude:</strong> {{ $item->latitude ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Longitude:</strong> {{ $item->longitude ?? '-' }}</p>
                    </div>
                </div>

                @if($item->latitude && $item->longitude)
                    <div class="mt-3">
                        <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}"
                           target="_blank"
                           class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-map-marked-alt me-1"></i>
                            Lihat di Google Maps
                        </a>
                    </div>
                @endif
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

{{-- ================= MODAL LAPORAN - DIPINDAH KE LUAR TABEL ================= --}}
<div class="modal fade" id="laporanModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('teknisi.laporan') }}" method="POST">
            @csrf
            <input type="hidden" name="pemesanan_id" value="{{ $item->id }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-file-alt me-2"></i>
                        Laporan Survei
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="hasil" class="form-select laporan-status"
                            data-target="{{ $item->id }}" required>
                            <option value="">-- Pilih --</option>
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>

                    <div class="mt-3 d-none" id="alasanBox{{ $item->id }}">
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea name="alasan_penolakan" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane me-1"></i>
                        Kirim
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- ================= SCRIPT TOGGLE ALASAN ================= --}}
<script>
document.querySelectorAll('.laporan-status').forEach(el => {
    el.addEventListener('change', function () {
        const box = document.getElementById('alasanBox' + this.dataset.target);
        this.value === 'ditolak'
            ? box.classList.remove('d-none')
            : box.classList.add('d-none');
    });
});
</script>

@endsection