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
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="80">
                            </a>
                            <div class="logo-text">Technest Academy</div>
                            <div class="logo-subtitle">Daftar untuk mulai belajar</div>
                        </div>

                        <div class="welcome-text">
                            <h2>Buat Akun Baru</h2>
                            <p>Gabung dan mulai perjalanan belajar Anda bersama Technest Academy</p>
                        </div>

                        <!-- Alert Container -->
                        <div class="alert-container" id="alertContainer"></div>

                        <form id="registerForm" method="POST" action="{{ route('register.post') }}">
                            @csrf

                            <div class="input-group-custom">
                                <i class="input-icon bi bi-person"></i>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}"
                                    required>
                            </div>

                            <!-- Email Input -->
                            <div class="input-group-custom">
                                <i class="input-icon bi bi-envelope"></i>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Email Address"
                                    value="{{ old('email') }}" required>
                            </div>

                            <!-- Password Input -->
                            <div class="input-group-custom">
                                <i class="input-icon bi bi-lock"></i>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Password" required>
                                <button type="button" class="password-toggle"
                                    onclick="togglePassword('password','passwordToggleIcon')">
                                    <i class="bi bi-eye" id="passwordToggleIcon"></i>
                                </button>
                            </div>

                            <!-- Confirm Password Input -->
                            <div class="input-group-custom">
                                <i class="input-icon bi bi-shield-lock"></i>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Konfirmasi Password" required>
                                <button type="button" class="password-toggle"
                                    onclick="togglePassword('password_confirmation','passwordToggleIcon2')">
                                    <i class="bi bi-eye" id="passwordToggleIcon2"></i>
                                </button>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-login" id="registerButton">
                                <span id="buttonText">Daftar Sekarang</span>
                                <span id="loadingSpinner" style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Memproses...
                                </span>
                            </button>
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
        // Modern Alert Function
        function showAlert(type, title, message) {
            const alertContainer = document.getElementById('alertContainer');

            const alertDiv = document.createElement('div');
            alertDiv.className = `modern-alert alert-${type}`;

            const icon = type === 'error' ? 'bi-x-circle-fill' : 'bi-check-circle-fill';

            alertDiv.innerHTML = `
                <div class="alert-icon">
                    <i class="bi ${icon}"></i>
                </div>
                <div class="alert-content">
                    <div class="alert-title">${title}</div>
                    <p class="alert-message">${message}</p>
                </div>
                <button class="alert-close" onclick="closeAlert(this)">
                    <i class="bi bi-x"></i>
                </button>
            `;

            alertContainer.appendChild(alertDiv);

            // Auto dismiss after 5 seconds
            setTimeout(() => {
                closeAlert(alertDiv.querySelector('.alert-close'));
            }, 5000);
        }

        function closeAlert(button) {
            const alert = button.closest('.modern-alert');
            alert.classList.add('hiding');
            setTimeout(() => {
                alert.remove();
            }, 300);
        }

        // Show Laravel validation errors
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                showAlert('error', 'Registrasi Gagal', '{{ $error }}');
            @endforeach
        @endif

        // Show success message
        @if (session('success'))
            showAlert('success', 'Berhasil!', '{{ session('success') }}');
        @endif

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

        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            const registerButton = document.getElementById('registerButton');
            const buttonText = document.getElementById('buttonText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            let isValid = true;

            // Reset validation
            [name, email, password, passwordConfirmation].forEach(input => {
                input.classList.remove('is-invalid');
            });

            // Validate name
            if (name.value.trim().length < 3) {
                name.classList.add('is-invalid');
                showAlert('error', 'Nama Tidak Valid', 'Nama minimal harus 3 karakter.');
                isValid = false;
            }

            // Validate email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value)) {
                email.classList.add('is-invalid');
                showAlert('error', 'Email Tidak Valid', 'Mohon masukkan format email yang benar.');
                isValid = false;
            }

            // Validate password
            if (password.value.length < 6) {
                password.classList.add('is-invalid');
                showAlert('error', 'Password Terlalu Pendek', 'Password minimal harus 6 karakter.');
                isValid = false;
            }

            // Validate password confirmation
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.classList.add('is-invalid');
                showAlert('error', 'Password Tidak Cocok', 'Konfirmasi password tidak sesuai dengan password.');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            // Show loading state
            registerButton.disabled = true;
            buttonText.style.display = 'none';
            loadingSpinner.style.display = 'inline-block';
        });

        // Input focus effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>

</html>
