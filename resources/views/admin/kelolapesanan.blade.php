@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold">Kelola Pesanan WiFi</h3>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover mt-3">
        <thead class="table-light">
            <tr>
                <th>Pelanggan</th>
                <th>Paket</th>
                <th>Status</th>
                <th>Laporan Teknisi</th>
                <th>Tagihan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        @foreach($pesanan as $p)
            <tr>
                <td>{{ $p->pelanggan->nama }}</td>
                <td>{{ $p->paket->nama_paket }}</td>

                <td>
                    @if($p->status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($p->status == 'diterima')
                        <span class="badge bg-info">Menunggu Survei</span>
                    @elseif($p->status == 'survei_selesai')
                        <span class="badge bg-primary">Survei Selesai</span>
                    @elseif($p->status == 'butuh_tagihan')
                        <span class="badge bg-secondary">Menunggu Dibuatkan Tagihan</span>
                    @elseif($p->status == 'menunggu_pembayaran')
                        <span class="badge bg-warning">Menunggu Pembayaran</span>
                    @elseif($p->status == 'lunas')
                        <span class="badge bg-success">Lunas</span>
                    @endif
                </td>

                <td>
                    @if($p->laporan_teknisi)
                        <small>{{ $p->laporan_teknisi }}</small>
                    @else
                        <span class="text-muted">Belum ada laporan</span>
                    @endif
                </td>

                <td>
                    @if($p->tagihan)
                        Rp {{ number_format($p->tagihan->nominal, 0, ',', '.') }} <br>

                        @if($p->tagihan->status == 'menunggu_pembayaran')
                            <span class="badge bg-warning">Menunggu Bukti</span>
                        @else
                            <span class="badge bg-success">Lunas</span>
                        @endif

                        @if($p->tagihan->bukti_pembayaran)
                            <br>
                            <button class="btn btn-sm btn-info mt-1" data-bs-toggle="modal"
                                data-bs-target="#buktiModal{{ $p->id }}">Lihat Bukti</button>
                        @endif

                    @else
                        <span class="text-muted">Belum ada tagihan</span>
                    @endif
                </td>

                <td>
                    {{-- STATUS PENDING --}}
                    @if($p->status == 'pending')
                        <form action="{{ route('superadmin.pesanan.terima', $p->id) }}" method="POST" class="d-inline">
                            @csrf @method('PUT')
                            <button class="btn btn-success btn-sm">Terima</button>
                        </form>

                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#tolakModal{{ $p->id }}">Tolak</button>

                    {{-- STATUS DITERIMA → MENUNGGU SURVEI --}}
                    @elseif($p->status == 'diterima')
                        <span class="text-muted">Menunggu Laporan Teknisi...</span>

                    {{-- STATUS SURVEI SELESAI → ADMIN BISA BUAT TAGIHAN --}}
                    @elseif($p->status == 'survei_selesai')
                        <form action="{{ route('superadmin.pesanan.buatTagihan', $p->id) }}" method="POST" class="d-inline">
                            @csrf @method('PUT')
                            <button class="btn btn-primary btn-sm">Buat Tagihan</button>
                        </form>

                    {{-- MENUNGGU PEMBAYARAN --}}
                    @elseif($p->status == 'menunggu_pembayaran')
                        <span class="text-muted">Menunggu bukti bayar...</span>

                    {{-- TAGIHAN LUNAS --}}
                    @elseif($p->status == 'lunas')
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#jadwalModal{{ $p->id }}">
                            Atur Jadwal Instalasi
                        </button>
                    @endif
                </td>
            </tr>

            {{-- Modal Tolak --}}
            <div class="modal fade" id="tolakModal{{ $p->id }}">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('superadmin.pesanan.tolak', $p->id) }}" class="modal-content">
                        @csrf @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title">Alasan Penolakan</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <textarea name="alasan_penolakan" required class="form-control"
                                placeholder="Masukkan alasan penolakan..."></textarea>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-danger">Tolak</button>
                        </div>

                    </form>
                </div>
            </div>

            {{-- Modal Bukti Pembayaran --}}
            @if($p->tagihan && $p->tagihan->bukti_pembayaran)
            <div class="modal fade" id="buktiModal{{ $p->id }}">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <img src="{{ asset('storage/' . $p->tagihan->bukti_pembayaran) }}" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
            @endif

        @endforeach
        </tbody>
    </table>
</div>
@endsection
