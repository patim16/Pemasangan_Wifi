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
    
    .bill-card {
        border: 1px solid #e3e8f0;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .bill-card:hover {
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
    
    .invoice-code {
        font-family: monospace;
        background-color: #f0f7ff;
        padding: 4px 8px;
        border-radius: 6px;
        color: #0066cc;
        font-weight: 600;
    }
    
    .amount-text {
        font-size: 1.1rem;
        font-weight: 700;
        color: #10b981;
    }
    
    .status-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }
    
    .status-badge i {
        margin-right: 4px;
    }
    
    .status-pending {
        background-color: #f3f4f6;
        color: #374151;
    }
    
    .status-dikirim {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .status-menunggu_verifikasi {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .status-lunas {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-ditolak {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .btn-action {
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-action:hover {
        transform: translateY(-1px);
        text-decoration: none;
        color: white;
    }
    
    .btn-primary {
        background-color: #0066cc;
        border-color: #0066cc;
    }
    
    .btn-primary:hover {
        background-color: #0052a3;
        border-color: #0052a3;
        box-shadow: 0 4px 12px rgba(0, 102, 204, 0.2);
    }
    
    .btn-warning {
        background-color: #f59e0b;
        border-color: #f59e0b;
    }
    
    .btn-warning:hover {
        background-color: #d97706;
        border-color: #d97706;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
    }
    
    .btn-success {
        background-color: #10b981;
        border-color: #10b981;
    }
    
    .btn-success:hover {
        background-color: #059669;
        border-color: #059669;
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
    
    .alert-info {
        background-color: #dbeafe;
        border: 1px solid #bfdbfe;
        color: #1e40af;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
    }
    
    .alert-info i {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
    }
    
    .rejection-reason {
        background-color: #fee2e2;
        border: 1px solid #fecaca;
        color: #991b1b;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 10px;
        font-size: 0.875rem;
    }
    
    .rejection-reason strong {
        color: #7f1d1d;
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
    
    .detail-table th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #374151;
        border: none;
    }
    
    .detail-table td {
        border: none;
        vertical-align: middle;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-file-invoice-dollar me-3"></i>Tagihan Saya
                    </h2>
                    <p class="mb-0 opacity-90">Kelola dan pantau tagihan Anda</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-list me-1"></i>
                            {{ $tagihan->count() }} Tagihan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ini tagihan di payment -->

    <div class="container">
        @if($tagihan->isEmpty())
            <div class="bill-card">
                <div class="card-body p-5">
                    <div class="empty-state">
                        <div class="empty-state-icon">📄</div>
                        <h5>Belum Ada Tagihan</h5>
                        <p>Anda belum memiliki tagihan yang perlu dibayar</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bill-card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Nominal</th>
                                <th>Jenis</th>
                                <th>Status</th>
                                <th width="220">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tagihan as $t)
                                @php
                                    // ==== SAFETY FIX ====
                                    $invoice = $t->invoice_code
                                        ?? 'INV-BLN-' . str_pad($t->id, 4, '0', STR_PAD_LEFT);

                                    $nominal = $t->nominal
                                        ?? ($t->paket->harga ?? 0);

                                    $namaPelanggan = $t->pelanggan->name
                                        ?? session('user')->name
                                        ?? '-';

                                    $namaPaket = $t->paket->nama_paket
                                        ?? $t->paket->nama
                                        ?? '-';
                                @endphp

                                <tr>
                                    {{-- INVOICE --}}
                                    <td>
                                        <span class="invoice-code">{{ $invoice }}</span>

                                        @if($t->jenis_tagihan == 'bulanan' || !empty($t->bulan))
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                Bulan: {{ $t->bulan ?? '-' }} <br>
                                                <i class="fas fa-clock me-1"></i>
                                                Jatuh Tempo: {{ $t->jatuh_tempo ?? '-' }}
                                            </small>
                                        @endif
                                    </td>

                                    {{-- NOMINAL --}}
                                    <td>
                                        <span class="amount-text">
                                            Rp {{ number_format($nominal, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    {{-- JENIS --}}
                                    <td>
                                        @if($t->jenis_tagihan == 'awal')
                                            <span class="badge bg-primary">
                                                <i class="fas fa-plus-circle me-1"></i>
                                                Tagihan Awal
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-sync-alt me-1"></i>
                                                Tagihan Bulanan
                                            </span>
                                        @endif
                                    </td>

                                    {{-- STATUS --}}
                                    <td>
                                        @switch($t->status)
                                            @case('pending')
                                            @case('menunggu_pembayaran')
                                            @case('belum_bayar')
                                                <span class="status-badge status-pending">
                                                    <i class="fas fa-clock"></i>
                                                    Belum Bayar
                                                </span>
                                                @break

                                            @case('dikirim')
                                                <span class="status-badge status-dikirim">
                                                    <i class="fas fa-paper-plane"></i>
                                                    Dikirim
                                                </span>
                                                @break

                                            @case('menunggu_verifikasi')
                                                <span class="status-badge status-menunggu_verifikasi">
                                                    <i class="fas fa-hourglass-half"></i>
                                                    Menunggu Verifikasi
                                                </span>
                                                @break

                                            @case('lunas')
                                                <span class="status-badge status-lunas">
                                                    <i class="fas fa-check-circle"></i>
                                                    Lunas
                                                </span>
                                                @break

                                            @case('ditolak')
                                                <span class="status-badge status-ditolak">
                                                    <i class="fas fa-times-circle"></i>
                                                    Ditolak
                                                </span>
                                                @break

                                            @default
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-question-circle"></i>
                                                    -
                                                </span>
                                        @endswitch
                                    </td>

                                    {{-- AKSI --}}
                                    <td>
                                        {{-- DITOLAK --}}
                                        @if($t->status === 'ditolak')
                                            <div class="rejection-reason">
                                                <strong><i class="fas fa-exclamation-triangle me-1"></i>Alasan:</strong>
                                                {{ $t->alasan_penolakan ?? '-' }}
                                            </div>

                                            <a href="{{ route(
                                                $t->jenis_tagihan == 'bulanan'
                                                    ? 'pelanggan.tagihan.bulanan.bayar'
                                                    : 'pelanggan.tagihan.bayar',
                                                $t->id
                                            ) }}"
                                               class="btn btn-sm btn-warning btn-action">
                                                <i class="fas fa-redo me-1"></i>
                                                Upload Ulang
                                            </a>
                                        @endif

                                        {{-- BELUM BAYAR --}}
                                        @if(in_array($t->status, ['pending','menunggu_pembayaran','belum_bayar','dikirim']))

                                            @php
                                                $routeBayar = $t->jenis_tagihan === 'awal'
                                                    ? route('pelanggan.tagihan.bayar.awal', $t->id)
                                                    : route('pelanggan.tagihan.bayar', $t->id);
                                            @endphp

                                            <a href="{{ $routeBayar }}"
                                            class="btn btn-sm btn-primary btn-action">
                                                <i class="fas fa-credit-card me-1"></i>
                                                Bayar Sekarang
                                            </a>

                                        @endif

                                        {{-- MENUNGGU VERIFIKASI --}}
                                        @if($t->status === 'menunggu_verifikasi')
                                            <span class="text-muted">
                                                <i class="fas fa-spinner fa-spin me-1"></i>
                                                Pembayaran sedang diverifikasi
                                            </span>
                                        @endif

                                        {{-- LUNAS --}}
                                        @if($t->status === 'lunas')
                                            <button
                                                class="btn btn-sm btn-success btn-action btnDetailInvoice"
                                                data-invoice="{{ $invoice }}"
                                                data-nama="{{ $namaPelanggan }}"
                                                data-paket="{{ $namaPaket }}"
                                                data-harga="{{ number_format($nominal,0,',','.') }}"
                                                data-status="{{ ucfirst($t->status) }}"
                                                data-bukti="{{ $t->bukti_pembayaran ? asset('storage/'.$t->bukti_pembayaran) : '' }}"
                                            >
                                                <i class="fas fa-eye me-1"></i>
                                                Detail
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- MODAL DETAIL - DIPINDAH KE LUAR TABEL --}}
<div class="modal fade" id="invoiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-file-invoice me-2"></i>
                    Detail Invoice
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <table class="table detail-table">
                    <tr>
                        <th width="180">
                            <i class="fas fa-receipt me-2"></i>
                            No Invoice
                        </th>
                        <td id="mInvoice"></td>
                    </tr>
                    <tr>
                        <th>
                            <i class="fas fa-user me-2"></i>
                            Nama Pelanggan
                        </th>
                        <td id="mNama"></td>
                    </tr>
                    <tr>
                        <th>
                            <i class="fas fa-wifi me-2"></i>
                            Paket Internet
                        </th>
                        <td id="mPaket"></td>
                    </tr>
                    <tr>
                        <th>
                            <i class="fas fa-money-bill-wave me-2"></i>
                            Total Pembayaran
                        </th>
                        <td id="mHarga" class="fw-bold text-success"></td>
                    </tr>
                    <tr>
                        <th>
                            <i class="fas fa-info-circle me-2"></i>
                            Status
                        </th>
                        <td id="mStatus"></td>
                    </tr>
                </table>

                <div class="mt-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-image me-2"></i>
                        Bukti Pembayaran
                    </h6>
                    <img id="mBukti" class="img-fluid rounded shadow-sm" style="max-height:280px">
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

{{-- SCRIPT MODAL --}}
<script>
document.addEventListener("click", function(e){
    if(e.target.classList.contains("btnDetailInvoice")) {
        document.getElementById("mInvoice").innerText = e.target.dataset.invoice;
        document.getElementById("mNama").innerText    = e.target.dataset.nama;
        document.getElementById("mPaket").innerText   = e.target.dataset.paket;
        document.getElementById("mHarga").innerText   = "Rp " + e.target.dataset.harga;
        document.getElementById("mStatus").innerText  = e.target.dataset.status;
        document.getElementById("mBukti").src         = e.target.dataset.bukti;

        new bootstrap.Modal(document.getElementById("invoiceModal")).show();
    }
});
</script>

@endsection