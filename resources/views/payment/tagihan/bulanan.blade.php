@extends('layout.app')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0 text-primary">Daftar Tagihan Bulanan</h2>

        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
            <i class="bi bi-calendar-month me-1"></i> Tagihan Bulanan
        </span>
    </div>

    {{-- CARD --}}
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-body p-4">

            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-3 d-flex align-items-center mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary bg-opacity-10">
                        <tr>
                            <th class="px-4 py-3 text-muted fw-semibold">Pelanggan</th>
                            <th class="px-4 py-3 text-muted fw-semibold">Paket</th>
                            <th class="px-4 py-3 text-muted fw-semibold">Bulan</th>
                            <th class="px-4 py-3 text-muted fw-semibold text-end">Total</th>
                            <th class="px-4 py-3 text-muted fw-semibold text-center">Status</th>
                            <th class="px-4 py-3 text-muted fw-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($tagihan as $t)
                        <tr class="border-bottom border-light">

                            {{-- PELANGGAN --}}
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm bg-primary bg-opacity-10 rounded-circle me-3">
                                        <span class="text-primary fw-bold">
                                            {{ strtoupper(substr($t->pelanggan->nama, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $t->pelanggan->nama }}</div>
                                        <small class="text-muted d-none d-md-block">
                                            {{ $t->pelanggan->email ?? '-' }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            {{-- PAKET --}}
                            <td class="px-4 py-3">
                                <span class="badge bg-light border border-secondary-subtle text-dark px-3 py-2 rounded-pill">
                                    {{ $t->paket->nama }}
                                </span>
                            </td>

                            {{-- BULAN --}}
                            <td class="px-4 py-3">
                                <i class="bi bi-calendar-event text-muted me-2"></i>
                                <span class="fw-semibold">{{ $t->bulan }}</span>
                            </td>

                            {{-- TOTAL --}}
                            <td class="px-4 py-3 text-end">
                                <span class="fw-bold text-success">
                                    Rp {{ number_format($t->nominal, 0, ',', '.') }}
                                </span>
                            </td>

                            {{-- STATUS --}}
                            <td class="px-4 py-3 text-center">
                                @switch($t->status)
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

                                    @case('dikirim')
                                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                                            <i class="bi bi-send-check me-1"></i> Dikirim
                                        </span>
                                    @break

                                    @case('ditolak')
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">
                                            <i class="bi bi-exclamation-triangle me-1"></i> Ditolak
                                        </span>
                                    @break
                                @endswitch
                            </td>

                            {{-- AKSI --}}
                            <td class="px-4 py-3 d-flex gap-2">

                                {{-- DETAIL --}}
                                <a href="{{ route('payment.tagihan.detail', $t->id) }}" 
                                   class="btn btn-primary btn-sm rounded-pill">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>

                                {{-- KIRIM TAGIHAN --}}
                                @if($t->status == 'belum bayar')
                                <form method="POST" action="{{ route('payment.tagihan.kirim', $t->id) }}">
                                    @csrf
                                    <button class="btn btn-warning btn-sm rounded-pill">
                                        <i class="bi bi-send me-1"></i> Kirim Tagihan
                                    </button>
                                </form>
                                @endif

                            </td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inboxes mb-2 d-block" style="font-size: 2rem;"></i>
                                Tidak ada data tagihan bulanan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

{{-- STYLE --}}
@push('styles')
<style>
    .avatar {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.03);
    }
</style>
@endpush
@endsection
