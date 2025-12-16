<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Registrasi Pelanggan</h4>
                </div>

                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/register') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        <!-- No HP -->
                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <!-- Foto KTP (file upload) -->
                        <div class="mb-3">
                            <label class="form-label">Foto KTP (foto/jpg/png)</label>
                            <input type="file" name="foto_ktp" accept="image/*" class="form-control" required>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                          <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>

                        </div>


                        <button class="btn btn-success w-100">Daftar</button>

                        <p class="mt-3 text-center">
                            Sudah punya akun? <a href="{{ url('/login') }}">Login</a>
                        </p>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Browser kamu tidak mendukung GPS.");
    }
}

function showPosition(position) {
    document.getElementById("latitude").value = position.coords.latitude;
    document.getElementById("longitude").value = position.coords.longitude;
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            alert("Izin lokasi ditolak. Aktifkan GPS.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Lokasi tidak tersedia.");
            break;
        case error.TIMEOUT:
            alert("Timeout mengambil lokasi.");
            break;
        default:
            alert("Terjadi kesalahan mengambil lokasi.");
    }
}
</script>


</body>
</html>
