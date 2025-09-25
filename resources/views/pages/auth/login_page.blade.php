<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Technest Academy</title>
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
                            <img src="{{ asset('assets/img/logo.png') }}" alt="" srcset="" width="80">
                            <div class="logo-text">Technest Academy</div>
                            <div class="logo-subtitle">Platform Belajar Online Terdepan</div>
                        </div>

                        <div class="welcome-text">
                            <h2>Selamat Datang Kembali!</h2>
                            <p>Masuk ke akun Anda untuk melanjutkan perjalanan belajar</p>
                        </div>

                        <form id="loginForm" method="POST" action="{{ route('login.post') }}">
                            @csrf
                            <!-- Email Input -->
                            <div class="input-group-custom">
                                <i class="input-icon bi bi-envelope"></i>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Email Address" value="{{ old('email') }}" required>
                                <div class="invalid-feedback" id="emailError" style="display: none;">
                                    Email tidak valid
                                </div>
                            </div>

                            <!-- Password Input -->
                            <div class="input-group-custom">
                                <i class="input-icon bi bi-lock"></i>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" required>
                                <button type="button" class="password-toggle" onclick="togglePassword()">
                                    <i class="bi bi-eye" id="passwordToggleIcon"></i>
                                </button>
                                <div class="invalid-feedback" id="passwordError" style="display: none;">
                                    Password minimal 6 karakter
                                </div>
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="remember-forgot">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Ingat saya</label>
                                </div>
                                <a href="" class="forgot-link">Lupa password?</a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-login" id="loginButton">
                                <span id="buttonText">Masuk ke Akun</span>
                                <span id="loadingSpinner" style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Memproses...
                                </span>
                            </button>
                        </form>

                        <div class="signup-link">
                            <p>Belum memiliki akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6 d-none d-lg-block">
                    <div class="login-illustration">
                        <div class="illustration-content">
                            <div class="illustration-icon">
                                <i class="bi bi-rocket-takeoff"></i>
                            </div>
                            <h3>Mulai Perjalanan Tech Career Anda</h3>
                            <p>Bergabunglah dengan 50,000+ siswa yang telah mempercayai Technest Academy untuk
                                mengembangkan skill teknologi mereka.</p>

                            <ul class="feature-list">
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    Akses ke 200+ kursus premium
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    Sertifikat yang diakui industri
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    Mentoring dari expert berpengalaman
                                </li>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    Career support dan job placement
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }


        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const loginButton = document.getElementById('loginButton');
            const buttonText = document.getElementById('buttonText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            let isValid = true;


            email.classList.remove('is-invalid');
            password.classList.remove('is-invalid');
            document.getElementById('emailError').style.display = 'none';
            document.getElementById('passwordError').style.display = 'none';

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value)) {
                email.classList.add('is-invalid');
                document.getElementById('emailError').style.display = 'block';
                isValid = false;
            }

            if (password.value.length < 6) {
                password.classList.add('is-invalid');
                document.getElementById('passwordError').style.display = 'block';
                isValid = false;
            }

            if (isValid) {
                // Show loading state
                loginButton.disabled = true;
                buttonText.style.display = 'none';
                loadingSpinner.style.display = 'inline-block';

                // Submit form
                e.target.submit();
            }
        });

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
