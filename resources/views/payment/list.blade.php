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
    
    .btn-danger {
        background-color: #ef4444;
        border-color: #ef4444;
    }
    
    .btn-danger:hover {
        background-color: #dc2626;
        border-color: #dc2626;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
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
    
    .avatar {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 102, 204, 0.1);
        border-radius: 50%;
        color: #0066cc;
        font-weight: 600;
    }
    
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 6px;
    }
    
    /* Pagination Styles */
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
                        <i class="fas fa-clock me-3"></i>Daftar Pembayaran Menunggu Verifikasi
                    </h2>
                    <p class="mb-0 opacity-90">Verifikasi pembayaran yang telah dikirim oleh pelanggan</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-clock-history me-1"></i>
                            {{ $data->where('status','menunggu_verifikasi')->count() }} Menunggu
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
                            <th>Invoice</th>
                            <th>Pelanggan</th>
                            <th>Paket</th>
                            <th>Jenis</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Bukti</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            {{-- INVOICE --}}
                            <td>
                                <span class="id-badge">{{ $item->invoice_code ?? '—' }}</span>
                            </td>

                            {{-- PELANGGAN --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3">
                                        <span>{{ strtoupper(substr(optional($item->pelanggan)->nama ?? '-', 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $item->pelanggan->nama ?? '-' }}</div>
                                        <small class="text-muted">{{ $item->pelanggan->email ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>

                            {{-- PAKET --}}
                            <td>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-wifi me-1"></i>
                                    {{ optional($item->paket)->nama_paket ?? '-' }}
                                </span>
                            </td>

                            {{-- JENIS --}}
                            <td>
                                @if($item->jenis === 'awal')
                                    <span class="status-badge" style="background-color: #dbeafe; color: #1e40af;">
                                        <i class="fas fa-file-invoice"></i>
                                        Tagihan Awal
                                    </span>
                                @else
                                    <span class="status-badge" style="background-color: #fef3c7; color: #92400e;">
                                        <i class="fas fa-calendar-alt"></i>
                                        Bulanan
                                    </span>
                                @endif
                            </td>

                            {{-- TOTAL --}}
                            <td class="text-end">
                                <div class="fw-bold text-success">
                                    Rp {{ number_format($item->nominal ?? 0, 0, ',', '.') }}
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $item->created_at->diffForHumans() }}
                                </small>
                            </td>

                            {{-- BUKTI --}}
                            <td class="text-center">
                                {{-- TAGIHAN AWAL --}}
                                @if($item->jenis === 'awal')
                                    @if($item->bukti)
                                        <button class="btn btn-sm btn-outline-primary btn-action rounded-pill"
                                                data-bs-toggle="modal"
                                                data-bs-target="#buktiAwal{{ $item->id }}">
                                            <i class="fas fa-image me-1"></i> Lihat
                                        </button>
                                    @else
                                        <span class="text-muted">Belum ada</span>
                                    @endif

                                {{-- TAGIHAN BULANAN --}}
                                @elseif($item->jenis === 'bulanan')
                                    @if($item->bukti_pembayaran)
                                        <button class="btn btn-sm btn-outline-primary btn-action rounded-pill"
                                                data-bs-toggle="modal"
                                                data-bs-target="#buktiBulanan{{ $item->id }}">
                                            <i class="fas fa-image me-1"></i> Lihat
                                        </button>
                                    @else
                                        <span class="text-muted">Belum ada</span>
                                    @endif
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="text-center">
                                @if($item->status === 'menunggu_verifikasi')
                                    <div class="action-buttons">
                                        {{-- ================= TAGIHAN AWAL ================= --}}
                                        @if($item->jenis === 'awal')
                                            <form action="{{ route('valid',$item->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-success btn-sm rounded-pill">
                                                    <i class="bi bi-check-circle me-1"></i> Terima
                                                </button>
                                            </form>

                                            <button class="btn btn-danger btn-sm rounded-pill"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#tolakAwal{{ $item->id }}">
                                                <i class="bi bi-x-circle me-1"></i> Tolak
                                            </button>

                                        {{-- ================= TAGIHAN BULANAN ================= --}}
                                        @elseif($item->jenis === 'bulanan')
                                            <form action="{{ route('verifikasi.tagihan.terima',$item->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-success btn-sm rounded-pill">
                                                    <i class="bi bi-check-circle me-1"></i> Terima Bulanan
                                                </button>
                                            </form>

                                                <button class="btn btn-danger btn-sm rounded-pill"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#tolakBulanan{{ $item->id }}">
                                                    <i class="bi bi-x-circle me-1"></i> Tolak Bulanan
                                                </button>

                                            <!-- <form action="{{ route('verifikasi.tagihan.tolak',$item->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                
                                            </form> -->
                                        @endif
                                    </div>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ ucfirst(str_replace('_',' ',$item->status)) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📋</div>
                                    <h5>Tidak Ada Pembayaran Menunggu Verifikasi</h5>
                                    <p>Semua pembayaran telah diverifikasi atau tidak ada pembayaran yang menunggu verifikasi saat ini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($data->hasPages())
            <div class="pagination-container">
                {{ $data->links('pagination::bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ================= MODAL BUKTI TAGIHAN AWAL ================= --}}
@foreach ($data as $item)
    @if($item->jenis === 'awal' && $item->bukti)
        <div class="modal fade" id="buktiAwal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-image me-2"></i>
                            Bukti Pembayaran (Tagihan Awal)
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <img src="{{ asset('storage/'.$item->bukti) }}"
                             class="img-fluid rounded shadow" alt="Bukti Pembayaran">
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ================= MODAL BUKTI TAGIHAN BULANAN ================= --}}
    @if($item->jenis === 'bulanan' && $item->bukti_pembayaran)
        <div class="modal fade" id="buktiBulanan{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-image me-2"></i>
                            Bukti Pembayaran Bulanan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <img src="{{ asset('storage/'.$item->bukti_pembayaran) }}"
                             class="img-fluid rounded shadow" alt="Bukti Pembayaran">
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ================= MODAL TOLAK TAGIHAN AWAL ================= --}}
    @if($item->jenis === 'awal')
        <div class="modal fade" id="tolakAwal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('invalid',$item->id) }}" method="POST">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title text-danger">
                                <i class="fas fa-times-circle me-2"></i>
                                Tolak Pembayaran
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label">Alasan Penolakan</label>
                                <textarea name="alasan_penolakan"
                                          class="form-control" rows="3"
                                          required
                                          placeholder="Masukkan alasan penolakan pembayaran"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-secondary rounded-pill"
                                    data-bs-dismiss="modal">
                                Batal
                            </button>

                            <button class="btn btn-danger rounded-pill">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Tolak Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    {{-- ================= MODAL TOLAK TAGIHAN BULANAN ================= --}}
    @if($item->jenis === 'bulanan')
        <div class="modal fade" id="tolakBulanan{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('invalid.bulanan',$item->id) }}" method="POST">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title text-danger">
                                <i class="fas fa-times-circle me-2"></i>
                                Tolak Pembayaran
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label">Alasan Penolakan</label>
                                <textarea name="alasan_penolakan"
                                          class="form-control" rows="3"
                                          required
                                          placeholder="Masukkan alasan penolakan pembayaran"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-secondary rounded-pill"
                                    data-bs-dismiss="modal">
                                Batal
                            </button>

                            <button type="submit" class="btn btn-danger rounded-pill">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Tolak Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded",function(){
 const rows=document.querySelectorAll('tbody tr');
 rows.forEach((row,i)=>{
  setTimeout(()=>{
   row.style.opacity='0';
   row.style.transform='translateY(10px)';
   row.style.transition='all .3s ease';
   setTimeout(()=>{
     row.style.opacity='1';
     row.style.transform='translateY(0)';
   },50);
  },i*30);
 });
});
</script>
@endpush

@endsection