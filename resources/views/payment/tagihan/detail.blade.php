@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">Detail Tagihan Bulanan</h2>
    </div>

    {{-- CARD --}}
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="card-body p-4">

            {{-- INFO UTAMA --}}
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Pelanggan</h6>
                    <div class="fw-bold">{{ $tagihan->pelanggan->nama }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Paket</h6>
                    <div class="fw-bold">{{ $tagihan->paket->nama }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Bulan Tagihan</h6>
                    <div class="fw-bold">{{ $tagihan->bulan }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Total Tagihan</h6>
                    <div class="fw-bold text-success">
                        Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Status</h6>

                    @switch($tagihan->status)
                        @case('lunas')
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                <i class="bi bi-check-circle me-1"></i> Lunas
                            </span>
                        @break

                        @case('menunggu_verifikasi')
                            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">
                                <i class="bi bi-hourglass-split me-1"></i> Menunggu Verifikasi
                            </span>
                        @break

                        @case('belum bayar')
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                                <i class="bi bi-x-circle me-1"></i> Belum Bayar
                            </span>
                        @break

                        @case('ditolak')
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">
                                <i class="bi bi-exclamation-triangle me-1"></i> Ditolak
                            </span>
                        @break
                    @endswitch
                </div>
            </div>

            <hr>

            {{-- BUKTI PEMBAYARAN --}}
            <h5 class="fw-semibold mb-3">Bukti Pembayaran</h5>

            @if($tagihan->bukti_pembayaran)
                <div class="text-center mb-4">
                    <img src="{{ asset('uploads/bukti/' . $tagihan->bukti_pembayaran) }}"
                         class="img-thumbnail shadow-sm rounded"
                         style="max-width: 350px;">
                </div>
            @else
                <p class="text-danger fst-italic">Belum ada bukti pembayaran.</p>
            @endif

            {{-- TOMBOL KONFIRMASI --}}
            @if($tagihan->status !== 'lunas')
                <form action="{{ route('payment.tagihan.konfirmasi', $tagihan->id) }}" method="POST" class="mt-3">
                    @csrf
                    <button class="btn btn-success px-4 py-2 rounded-pill">
                        <i class="bi bi-check-circle me-1"></i> Konfirmasi Lunas
                    </button>
                </form>
            @endif

        </div>
    </div>

</div>

{{-- STYLE TAMBAHAN --}}
@push('styles')
<style>
    .card-body h6 {
        font-size: 0.85rem;
    }
</style>
@endpush

@endsection
