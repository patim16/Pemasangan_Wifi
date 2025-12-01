@extends('layout.app')

@section('content')

<h2 class="fw-bold mb-3">Detail Pembayaran</h2>

<div class="card p-4 shadow-sm">

    <div class="row mb-3">
        <div class="col-md-6">
            <p><strong>Pelanggan:</strong> {{ $trx->pelanggan->nama }}</p>
            <p><strong>Paket:</strong> {{ $trx->paket->nama }}</p>
            <p><strong>Total Pembayaran:</strong> 
                Rp {{ number_format($trx->total, 0, ',', '.') }}
            </p>
            <p><strong>Status Saat Ini:</strong> 
                <span class="badge text-bg-primary">{{ $trx->status }}</span>
            </p>
        </div>

        <div class="col-md-6 text-center">
            <p class="fw-bold">Bukti Pembayaran:</p>

            @if($trx->bukti)
                <img src="{{ asset('uploads/bukti/' . $trx->bukti) }}" 
                     class="img-thumbnail mb-2"
                     style="max-width: 300px;">
                
                <br>
                <a href="{{ asset('uploads/bukti/' . $trx->bukti) }}" 
                   target="_blank"
                   class="btn btn-info btn-sm">
                    Download Bukti
                </a>
            @else
                <p class="text-danger">Belum ada bukti pembayaran</p>
            @endif
        </div>
    </div>

    <hr>

    <div class="d-flex gap-2">

        {{-- Tombol Verifikasi --}}
        <form action="{{ route('payment.valid', $trx->id) }}" method="POST">
            @csrf
            <button class="btn btn-success">Verifikasi (Valid)</button>
        </form>

        {{-- Tombol Tolak --}}
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalTolak">
            Tolak (Invalid)
        </button>
    </div>

</div>

{{-- Modal Input Alasan Penolakan --}}
<div class="modal fade" id="modalTolak">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('payment.invalid', $trx->id) }}" class="modal-content">
            @csrf

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Alasan Penolakan Pembayaran</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <textarea name="alasan" class="form-control" required placeholder="Masukkan alasan penolakan"></textarea>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger">Kirim Penolakan</button>
            </div>

        </form>
    </div>
</div>

@endsection
