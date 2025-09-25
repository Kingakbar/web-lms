<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Technest Academy</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="row g-0 login-row">
                <div class="col-lg-6">
                    <div class="login-form-section">
                        <div class="logo-section">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="80">
                            <div class="logo-text">Technest Academy</div>
                            <div class="logo-subtitle">Daftar untuk mulai belajar</div>
                        </div>

                        <div class="welcome-text">
                            <h2>Buat Akun Baru</h2>
                            <p>Gabung dan mulai perjalanan belajar Anda bersama Technest Academy</p>
                        </div>

                        <form id="registerForm" method="POST" action="{{ route('register.post') }}">
                            @csrf

                            <div class="input-group-custom">
                                <i class="input-icon bi bi-person"></i>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Input -->
                            <div class="input-group-custom">
                                <i class="input-icon bi bi-envelope"></i>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Email Address" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="input-group-custom">
                                <i class="input-icon bi bi-lock"></i>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" required>
                                <button type="button" class="password-toggle"
                                    onclick="togglePassword('password','passwordToggleIcon')">
                                    <i class="bi bi-eye" id="passwordToggleIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password Input -->
                            <div class="input-group-custom">
                                <i class="input-icon bi bi-shield-lock"></i>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Konfirmasi Password" required>
                                <button type="button" class="password-toggle"
                                    onclick="togglePassword('password_confirmation','passwordToggleIcon2')">
                                    <i class="bi bi-eye" id="passwordToggleIcon2"></i>
                                </button>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-login">Daftar Sekarang</button>
                        </form>

                        <div class="signup-link">
                            <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 d-none d-lg-block">
                    <div class="login-illustration">
                        <div class="illustration-content">
                            <div class="illustration-icon">
                                <i class="bi bi-stars"></i>
                            </div>
                            <h3>Belajar Lebih Cepat, Karier Lebih Cemerlang</h3>
                            <p>Dapatkan akses ke kursus premium, mentoring ahli, dan sertifikat yang diakui industri.
                            </p>
                            <ul class="feature-list">
                                <li><i class="bi bi-check-circle-fill"></i> Gratis akses materi dasar</li>
                                <li><i class="bi bi-check-circle-fill"></i> Diskon khusus member baru</li>
                                <li><i class="bi bi-check-circle-fill"></i> Forum komunitas aktif</li>
                                <li><i class="bi bi-check-circle-fill"></i> Dukungan karier & job placement</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
    </script>
</body>

</html>
