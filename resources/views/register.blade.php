<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - WiFi Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
            transition: transform 0.3s ease;
        }
        
        .register-card:hover {
            transform: translateY(-5px);
        }
        
        .register-header {
            background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .register-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 1.8rem;
        }
        
        .register-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }
        
        .register-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
        }
        
        .register-body {
            padding: 40px 30px;
            max-height: 60vh;
            overflow-y: auto;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            display: block;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group-text {
            background-color: #f8fafc;
            border: 1px solid #e5e7eb;
            border-right: none;
            color: #0066cc;
            border-radius: 10px 0 0 10px;
        }
        
        .form-control {
            border: 1px solid #e5e7eb;
            border-left: none;
            border-radius: 0 10px 10px 0;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #0066cc;
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
            outline: none;
        }
        
        .btn-register {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }
        
        .btn-register:active {
            transform: translateY(0);
        }
        
        .btn-location {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border: none;
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-location:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
        }
        
        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #6b7280;
        }
        
        .login-link a {
            color: #0066cc;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .login-link a:hover {
            color: #0052a3;
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            padding: 12px 15px;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        
        .file-upload input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-upload-label {
            display: block;
            padding: 12px 15px;
            background-color: #f8fafc;
            border: 2px dashed #e5e7eb;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-upload-label:hover {
            border-color: #0066cc;
            background-color: #f0f7ff;
        }
        
        /* Floating shapes for decoration */
        .shape {
            position: fixed;
            opacity: 0.1;
            z-index: -1;
        }
        
        .shape-1 {
            top: 10%;
            left: 10%;
            width: 200px;
            height: 200px;
            background: white;
            border-radius: 50%;
        }
        
        .shape-2 {
            bottom: 10%;
            right: 10%;
            width: 150px;
            height: 150px;
            background: white;
            border-radius: 50%;
        }
        
        .shape-3 {
            top: 50%;
            right: 5%;
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            .register-card {
                margin: 20px;
            }
            
            .register-header {
                padding: 25px 20px;
            }
            
            .register-body {
                padding: 30px 20px;
            }
        }
        
        /* Scrollbar styling */
        .register-body::-webkit-scrollbar {
            width: 6px;
        }
        
        .register-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .register-body::-webkit-scrollbar-thumb {
            background: #0066cc;
            border-radius: 10px;
        }
        
        .register-body::-webkit-scrollbar-thumb:hover {
            background: #0052a3;
        }
    </style>
</head>
<body>
    <!-- Decorative shapes -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>

    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="register-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h2>Registrasi Pelanggan</h2>
                <p>Buat akun baru untuk layanan WiFi</p>
            </div>

            <div class="register-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul>
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/register') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <label for="nama">
                            <i class="fas fa-user me-2"></i>Nama Lengkap
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" 
                                   name="nama" 
                                   class="form-control" 
                                   id="nama" 
                                   value="{{ old('nama') }}" 
                                   placeholder="Masukkan nama lengkap Anda" 
                                   required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope me-2"></i>Email
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" 
                                   name="email" 
                                   class="form-control" 
                                   id="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Masukkan email Anda" 
                                   required>
                        </div>
                    </div>

                    <!-- No HP -->
                    <div class="form-group">
                        <label for="no_hp">
                            <i class="fas fa-phone me-2"></i>Nomor HP
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input type="text" 
                                   name="no_hp" 
                                   class="form-control" 
                                   id="no_hp" 
                                   value="{{ old('no_hp') }}" 
                                   placeholder="Masukkan nomor HP Anda" 
                                   required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" 
                                   name="password" 
                                   class="form-control" 
                                   id="password" 
                                   placeholder="Masukkan password Anda" 
                                   required>
                        </div>
                    </div>

                    <!-- Foto KTP -->
                    <div class="form-group">
                        <label for="foto_ktp">
                            <i class="fas fa-image me-2"></i>Foto KTP
                        </label>
                        <div class="file-upload">
                            <input type="file" 
                                   name="foto_ktp" 
                                   id="foto_ktp" 
                                   accept="image/*" 
                                   required>
                            <label for="foto_ktp" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt me-2"></i>
                                <span id="file-name">Pilih file KTP (JPG/PNG)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="form-group">
                        <label for="alamat">
                            <i class="fas fa-map-marker-alt me-2"></i>Alamat Lengkap
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" style="align-items: start; padding-top: 12px;">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <textarea name="alamat" 
                                      class="form-control" 
                                      id="alamat" 
                                      rows="3" 
                                      placeholder="Masukkan alamat lengkap Anda">{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                  
                    <!-- Tombol Daftar -->
                    <button type="submit" class="btn btn-register">
                        <i class="fas fa-user-plus me-2"></i>
                        Daftar Sekarang
                    </button>
                </form>

                <div class="login-link">
                    <p class="mb-0">Sudah punya akun? 
                        <a href="{{ url('/login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Login di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // File upload preview
        document.getElementById('foto_ktp').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Pilih file KTP (JPG/PNG)';
            document.getElementById('file-name').textContent = fileName;
        });

        // Location functions
        function getLocation() {
            const btn = event.target;
            const originalText = btn.innerHTML;
            
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengambil lokasi...';
            btn.disabled = true;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        document.getElementById("latitude").value = position.coords.latitude;
                        document.getElementById("longitude").value = position.coords.longitude;
                        
                        btn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Lokasi berhasil diambil!';
                        btn.classList.remove('btn-location');
                        btn.classList.add('btn-success');
                        
                        setTimeout(() => {
                            btn.innerHTML = originalText;
                            btn.classList.remove('btn-success');
                            btn.classList.add('btn-location');
                            btn.disabled = false;
                        }, 2000);
                    },
                    function(error) {
                        let errorMessage = '';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage = "Izin lokasi ditolak. Aktifkan GPS.";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage = "Lokasi tidak tersedia.";
                                break;
                            case error.TIMEOUT:
                                errorMessage = "Timeout mengambil lokasi.";
                                break;
                            default:
                                errorMessage = "Terjadi kesalahan mengambil lokasi.";
                        }
                        
                        alert(errorMessage);
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                );
            } else {
                alert("Browser kamu tidak mendukung GPS.");
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }
    </script>
</body>
</html>