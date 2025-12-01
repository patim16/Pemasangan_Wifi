@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h2 class="fw-bold mb-3">Pilih Jadwal Instalasi</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{route('pelanggan.jadwal.simpan', $paket_id) }}" method="POST">
                @csrf

                <label class="fw-bold">Tanggal Instalasi</label>
                <input type="date" name="tanggal" class="form-control mb-3" required>

                <label class="fw-bold">Jam Instalasi</label>
                <select name="jam" class="form-control mb-3" required>
                    <option value="">-- Pilih Jam --</option>
                    <option>08:00 - 10:00</option>
                    <option>10:00 - 12:00</option>
                    <option>13:00 - 15:00</option>
                    <option>15:00 - 17:00</option>
                </select>

                <button class="btn btn-primary">Lanjut</button>
            </form>

        </div>
    </div>

</div>
@endsection
