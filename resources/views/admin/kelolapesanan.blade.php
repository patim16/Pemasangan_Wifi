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
                  <th>No</th>
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
                <td>{{ $pesanan->firstItem() + $loop->index }}</td>

                <td>{{ $p->pelanggan->nama ?? 'Nama tidak ditemukan' }}</td>
                <td>{{ $p->paket->nama_paket ?? 'Nama tidak ditemukan'}}</td>

                {{-- STATUS --}}
                <td>
                    <span class="badge bg-{{ 
                        $p->status == 'pending' ? 'warning text-dark' : 
                        ($p->status == 'menunggu_survei' ? 'info' :
                        ($p->status == 'survei_selesai' ? 'primary' :
                        ($p->status == 'menunggu_pembayaran' ? 'warning' :
                        ($p->status == 'lunas' ? 'success' : 'secondary'))))
                    }}">
                        {{ str_replace('_',' ', ucfirst($p->status)) }}
                    </span>
                </td>

                {{-- TEKNISI --}}
                <td>
                    @if($p->teknisi)
                        {{ $p->teknisi->nama }}
                    @else
                        <span class="text-muted">Belum ada</span>
                    @endif
                </td>

             {{-- LAPORAN --}}
<td>
    @if($p->status == 'ditolak_survei')
        <span class="text-danger">
            Ditolak: {{ $p->alasan_penolakan ?? '-' }}
        </span>

    @elseif($p->laporan_teknisi)
        <span class="text-success">
            {{ $p->laporan_teknisi }}
        </span>

    @else
        <span class="text-muted">-</span>
    @endif
</td>


                {{-- AKSI --}}
                <td>

                    {{-- 1. PENDING → Atur Survei --}}
                    @if($p->status == 'pending')
                        <button class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#surveiModal{{ $p->id }}">
                            Atur Survei
                        </button>

                    {{-- 2. MENUNGGU SURVEI --}}
                    @elseif($p->status == 'menunggu_survei')
                        <span class="text-muted">Menunggu survei teknisi...</span>

                    {{-- 3. SURVEI SELESAI --}}
                    @elseif($p->status == 'survei_selesai')
                        <span class="text-muted">Menunggu tagihan payment...</span>

                    {{-- 4. MENUNGGU PEMBAYARAN --}}
                    @elseif($p->status == 'menunggu_pembayaran')
                        <span class="text-muted">Menunggu bukti bayar...</span>

                    {{-- 5. LUNAS = atur instalasi --}}
                    @elseif($p->status == 'lunas')
                        <button class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#instalasiModal{{ $p->id }}">
                            Atur Instalasi
                        </button>

                    {{-- 6. SELESAI --}}
                    @elseif($p->status == 'selesai')
                        <span class="text-success">Selesai</span>

                    @endif

                    {{-- Tombol DETAIL --}}
                    <button class="btn btn-secondary btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#detailModal{{ $p->id }}">
                        Detail
                    </button>

                      <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editJadwalSurvei{{ $p->id }}">
  Edit
</button>

                </td>
            </tr>
          

<!-- Modal -->
<div class="modal fade" id="editJadwalSurvei{{ $p->id }}">
  <div class="modal-dialog">
    <form action="{{ route('pesanan.jadwalSurvei.update', $p->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="modal-content">
        <div class="modal-header">
          <h5>Edit Jadwal Survei</h5>
        </div>

        <div class="modal-body">
          <input type="datetime-local" name="jadwal_survei"
       value="{{ $p->jadwal_survei ? date('Y-m-d\TH:i', strtotime($p->jadwal_survei)) : '' }}"
       class="form-control" required>

          <label>Pilih Teknisi</label>
          <select name="teknisi_id" class="form-control">
            @foreach ($teknisi as $t)
              <option value="{{ $t->id }}" {{ $p->teknisi_id == $t->id ? 'selected' : '' }}>
                {{ $t->nama }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>


            {{-- ========================================================= --}}
            {{-- ===============   MODAL ATUR SURVEI   =================== --}}
            {{-- ========================================================= --}}

            <div class="modal fade" id="surveiModal{{ $p->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('admin.pesanan.jadwalSurvei', $p->id) }}" method="POST">
                        @csrf

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Atur Jadwal Survei</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <label class="form-label">Pilih Teknisi</label>
                                <select name="teknisi_id" class="form-select" required>
                                    <option value="">-- Pilih Teknisi --</option>
                                    @foreach($teknisi as $t)
                                        <option value="{{ $t->id }}">{{ $t->nama }}</option>
                                    @endforeach
                                </select>

                                <label class="form-label mt-3">Tanggal Survei</label>
                              <input type="datetime-local" name="jadwal_survei" class="form-control" required>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>


            {{-- ========================================================= --}}
            {{-- ===============   MODAL ATUR INSTALASI  ================= --}}
            {{-- ========================================================= --}}

            <div class="modal fade" id="instalasiModal{{ $p->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('admin.pesanan.jadwalInstalasi', $p->id) }}" method="POST">
                        @csrf

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Atur Jadwal Instalasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <label class="form-label">Tanggal Instalasi</label>
                                <input type="datetime-local" name="jadwal_instalasi" class="form-control" required>

                                <label class="form-label mt-3">Catatan (opsional)</label>
                                <textarea name="catatan" class="form-control" rows="3"></textarea>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>


            {{-- ========================================================= --}}
            {{-- ===============     MODAL DETAIL PESANAN    ============= --}}
            {{-- ========================================================= --}}

            <div class="modal fade" id="detailModal{{ $p->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Detail Pesanan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">


                          <p><b>Pelanggan:</b> {{ $p->pelanggan->nama ?? '-' }}</p>
                            <p><b>Pelanggan:</b> {{ $p->pelanggan->nama }}</p>
                            <p><b>Paket:</b> {{ $p->paket->nama_paket }}</p>
                            <p><b>Status:</b> {{ $p->status }}</p>

                            <hr>

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

                         <p><b>Laporan Teknisi:</b>
    @if($p->status == 'ditolak_survei')
        <span class="text-danger">
            Ditolak: {{ $p->alasan_penolakan }}
        </span>

    @elseif($p->laporan_teknisi)
        <span class="text-success">
            {{ $p->laporan_teknisi }}
        </span>

    @else
        <span class="text-muted">Belum ada laporan</span>
    @endif
</p>


                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>

                    </div>
                </div>
            </div>

        @endforeach
        </tbody>

    </table>
   <div class="d-flex justify-content-center mt-3">
    {{ $pesanan->links('pagination::bootstrap-5') }}
</div>


</div>
@endsection
