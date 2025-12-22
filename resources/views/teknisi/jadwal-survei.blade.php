@extends('layout.app')

@section('content')
<div class="container-fluid py-3">

    <h5 class="fw-bold mb-3">Jadwal Survei</h5>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
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
                        <td>#SRV{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>

                        <td>
                            <strong>{{ $item->pelanggan->nama }}</strong><br>
                            <small>{{ $item->pelanggan->no_hp }}</small>
                        </td>

                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->nama_paket }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->jadwal_survei)->format('d M Y H:i') }}
                        </td>

                        <td>
                            <span class="badge bg-warning">
                                {{ ucfirst(str_replace('_',' ', $item->status)) }}
                            </span>
                        </td>

                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#detailModal{{ $item->id }}">
                                Detail
                            </button>

                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#laporanModal{{ $item->id }}">
                                Kirim Laporan
                            </button>
                        </td>
                    </tr>

                    {{-- ================= MODAL DETAIL ================= --}}
                    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Survei</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p><b>Pelanggan:</b> {{ $item->pelanggan->nama }}</p>
                                    <p><b>No HP:</b> {{ $item->pelanggan->no_hp }}</p>
                                    <p><b>Alamat:</b> {{ $item->alamat }}</p>
                                    <p><b>Paket:</b> {{ $item->nama_paket }}</p>
                                    <p><b>Jadwal:</b>
                                        {{ \Carbon\Carbon::parse($item->jadwal_survei)->format('d M Y H:i') }}
                                    </p>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ================= MODAL LAPORAN ================= --}}
                    <div class="modal fade" id="laporanModal{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('teknisi.laporan') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pemesanan_id" value="{{ $item->id }}">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Laporan Survei</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <label>Status</label>
                                        <select name="hasil" class="form-select laporan-status"
                                            data-target="{{ $item->id }}" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="diterima">Diterima</option>
                                            <option value="ditolak">Ditolak</option>
                                        </select>

                                        <div class="mt-3 d-none" id="alasanBox{{ $item->id }}">
                                            <label>Alasan Penolakan</label>
                                            <textarea name="alasan_penolakan" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-success">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">
                            Belum ada jadwal survei
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- SCRIPT TOGGLE ALASAN --}}
<script>
document.querySelectorAll('.laporan-status').forEach(el => {
    el.addEventListener('change', function () {
        const target = this.dataset.target;
        const box = document.getElementById('alasanBox' + target);
        if (this.value === 'ditolak') {
            box.classList.remove('d-none');
        } else {
            box.classList.add('d-none');
        }
    });
});
</script>


@endsection
