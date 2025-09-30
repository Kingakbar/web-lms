<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Technest Academy" width="40">
            Technest Academy
        </a>

        <!-- Mobile Actions -->
        <div class="mobile-nav-actions">
            <button class="btn btn-outline-primary btn-sm" id="mobileCoursesBtn">
                <i class="bi bi-book me-1"></i> Kursus
            </button>
            <a href="#" class="btn btn-primary btn-sm">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </a>
        </div>

        <!-- Desktop Navigation -->
        <div class="desktop-nav w-100">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-3"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#courses" role="button" data-bs-toggle="dropdown">
                            Kursus
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <h6 class="dropdown-header">Kategori Populer</h6>
                            </li>
                            <li><a class="dropdown-item" href="#courses">
                                    <i class="bi bi-code-slash"></i>
                                    <span>Web Development</span>
                                </a></li>
                            <li><a class="dropdown-item" href="#courses">
                                    <i class="bi bi-robot"></i>
                                    <span>Data Science & AI</span>
                                </a></li>
                            <li><a class="dropdown-item" href="#courses">
                                    <i class="bi bi-phone"></i>
                                    <span>Mobile Development</span>
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#courses">
                                    <i class="bi bi-grid-3x3-gap"></i>
                                    <span>Lihat Semua Kursus</span>
                                </a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonial">Testimoni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                </ul>

                <div class="d-flex gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar Sekarang</a>
                    @endguest

                    @auth
                        <a href="{{ route('dashboard.student') }}" class="btn btn-primary">My Dashboard</a>
                    @endauth
                </div>

            </div>
        </div>
    </div>
</nav>
