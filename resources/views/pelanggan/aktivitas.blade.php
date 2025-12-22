@extends('layout.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Aktivitas</h2>

        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
            ← Kembali
        </a>
    </div>

    @forelse($aktivitas as $item)
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="fw-bold">{{ $item['judul'] }}</h5>
                <p class="mb-1">{{ $item['deskripsi'] }}</p>
                <small class="text-muted">📅 {{ $item['waktu'] }}</small>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada aktivitas.</p>
    @endforelse

</div>
@endsection
