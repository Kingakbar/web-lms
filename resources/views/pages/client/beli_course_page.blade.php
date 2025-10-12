@include('layouts.header_landing_page')




{{-- Navigation --}}
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
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
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
                        @if (auth()->user()->hasRole('admin'))
                            <a href="{{ route('dashboard.admin') }}" class="btn btn-primary">My Dashboard</a>
                        @elseif(auth()->user()->hasRole('instructor'))
                            <a href="{{ route('dashboard.instructor') }}" class="btn btn-primary">My Dashboard</a>
                        @elseif(auth()->user()->hasRole('student'))
                            <a href="{{ route('dashboard.student') }}" class="btn btn-primary">My Dashboard</a>
                        @endif
                    @endauth
                </div>


            </div>
        </div>
    </div>
</nav>


{{-- Hero Section --}}
<section class="course-hero">
    <div class="container">
        <div class="course-hero-content">
            <div class="breadcrumb-custom">
                <a href="{{ route('home') }}"><i class="bi bi-house-door"></i> Beranda</a>
                <i class="bi bi-chevron-right" style="font-size: 0.7rem; color: rgba(255,255,255,0.5);"></i>
                <a href="{{ route('courses.index') }}">Kursus</a>
                <i class="bi bi-chevron-right" style="font-size: 0.7rem; color: rgba(255,255,255,0.5);"></i>
                <span>{{ Str::limit($course->title, 30) }}</span>
            </div>

            <h1>{{ $course->title }}</h1>

            <div class="course-hero-meta">
                <div class="hero-meta-item">
                    <i class="bi bi-person-circle"></i>
                    <span>{{ $course->instructor->name ?? 'Instruktur' }}</span>
                </div>
                <div class="hero-meta-item">
                    <i class="bi bi-clock-history"></i>
                    <span>{{ $course->lessons->sum('duration') }} Menit</span>
                </div>
                <div class="hero-meta-item">
                    <i class="bi bi-collection-play"></i>
                    <span>{{ $course->lessons->count() }} Materi</span>
                </div>
                <div class="hero-meta-item">
                    <i class="bi bi-bar-chart-fill"></i>
                    <span>Semua Level</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Main Content --}}
<section class="course-detail-section">
    <div class="container mt-5">
        <div class="row">
            {{-- Left Column --}}
            <div class="col-lg-8">
                <div class="main-card">
                    {{-- Video Trailer --}}
                    @php
                        $trailer = $course->lessons->whereNotNull('video_url')->first();
                    @endphp

                    @if ($trailer)
                        <div class="video-container">
                            <div class="ratio" style="margin: 0; padding: 0;">
                                <iframe
                                    src="{{ Str::contains($trailer->video_url, 'youtube.com')
                                        ? str_replace('watch?v=', 'embed/', $trailer->video_url)
                                        : $trailer->video_url }}"
                                    title="Trailer {{ $course->title }}" allowfullscreen
                                    style="border: none; width: 100%; height: 100%; display: block;">
                                </iframe>
                            </div>
                        </div>
                    @elseif ($course->thumbnail)
                        <div class="video-container">
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="img-fluid w-100"
                                alt="{{ $course->title }}"
                                style="max-height: 450px; object-fit: cover; display: block; width: 100%;">
                        </div>
                    @endif

                    {{-- Instructor Info --}}
                    <div class="instructor-card">
                        <div class="instructor-info">
                            @if (!empty($course->instructor->profile_picture))
                                <img src="{{ asset('storage/' . $course->instructor->profile_picture) }}"
                                    class="instructor-avatar" alt="{{ $course->instructor->name }}">
                            @else
                                <div class="instructor-avatar-fallback">
                                    {{ strtoupper(substr($course->instructor->name ?? 'I', 0, 1)) }}
                                </div>
                            @endif
                            <div class="instructor-details">
                                <h5>{{ $course->instructor->name ?? 'Instruktur' }}</h5>
                                <p><i class="bi bi-patch-check-fill text-primary me-1"></i> Instruktur Profesional</p>
                            </div>
                        </div>
                    </div>

                    {{-- Tabs --}}
                    <div class="content-tabs">
                        <button class="tab-btn active" onclick="switchTab(event, 'overview')">
                            <i class="bi bi-info-circle me-1"></i> Deskripsi
                        </button>
                        <button class="tab-btn" onclick="switchTab(event, 'curriculum')">
                            <i class="bi bi-list-check me-1"></i> Kurikulum
                        </button>
                        <button class="tab-btn" onclick="switchTab(event, 'benefits')">
                            <i class="bi bi-stars me-1"></i> Benefit
                        </button>
                    </div>

                    <div class="tab-content">
                        {{-- Overview Tab --}}
                        <div id="overview" class="tab-pane active">
                            <h4 class="mb-3">Tentang Kursus Ini</h4>
                            <p style="color: #4b5563; line-height: 1.8; font-size: 1rem;">
                                {{ $course->description }}
                            </p>

                            <h5 class="mt-4 mb-3">Yang Akan Anda Pelajari</h5>
                            <ul class="highlights-list">
                                <li><i class="bi bi-check-circle-fill"></i> Memahami konsep dasar hingga mahir</li>
                                <li><i class="bi bi-check-circle-fill"></i> Praktik langsung dengan studi kasus nyata
                                </li>
                                <li><i class="bi bi-check-circle-fill"></i> Tips dan trik dari instruktur berpengalaman
                                </li>
                                <li><i class="bi bi-check-circle-fill"></i> Materi update mengikuti tren industri</li>
                                <li><i class="bi bi-check-circle-fill"></i> Akses ke komunitas eksklusif</li>
                            </ul>
                        </div>

                        {{-- Curriculum Tab --}}
                        <div id="curriculum" class="tab-pane">
                            <h4 class="mb-3">Materi Pembelajaran</h4>
                            <p class="text-muted mb-4">
                                <i class="bi bi-info-circle"></i>
                                {{ $course->lessons->count() }} pelajaran •
                                {{ $course->lessons->sum('duration') }} menit total durasi
                            </p>

                            @if ($course->lessons->isNotEmpty())
                                <ul class="curriculum-list">
                                    @foreach ($course->lessons as $index => $lesson)
                                        <li class="curriculum-item">
                                            <div class="curriculum-left">
                                                <div class="lesson-number">{{ $index + 1 }}</div>
                                                <div class="lesson-info">
                                                    <h6>{{ $lesson->title }}</h6>
                                                    <p>
                                                        @if ($lesson->video_url)
                                                            <i class="bi bi-play-circle me-1"></i> Video
                                                        @else
                                                            <i class="bi bi-file-text me-1"></i> Materi
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="lesson-duration">
                                                <i class="bi bi-clock"></i>
                                                <span>{{ $lesson->duration }} mnt</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #d1d5db;"></i>
                                    <p class="text-muted mt-3">Belum ada materi tersedia</p>
                                </div>
                            @endif
                        </div>

                        {{-- Benefits Tab --}}
                        <div id="benefits" class="tab-pane">
                            <h4 class="mb-3">Keuntungan Yang Anda Dapatkan</h4>
                            <p class="text-muted mb-4">Investasi terbaik untuk masa depan karir Anda</p>

                            <div class="benefits-grid">
                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="bi bi-infinity"></i>
                                    </div>
                                    <div class="benefit-text">
                                        <h6>Akses Seumur Hidup</h6>
                                        <p>Belajar kapan saja tanpa batasan waktu</p>
                                    </div>
                                </div>

                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="bi bi-award"></i>
                                    </div>
                                    <div class="benefit-text">
                                        <h6>Sertifikat Resmi</h6>
                                        <p>Dapatkan sertifikat setelah menyelesaikan kursus</p>
                                    </div>
                                </div>

                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </div>
                                    <div class="benefit-text">
                                        <h6>Update Gratis</h6>
                                        <p>Materi selalu diperbarui tanpa biaya tambahan</p>
                                    </div>
                                </div>

                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="bi bi-headset"></i>
                                    </div>
                                    <div class="benefit-text">
                                        <h6>Bimbingan Instruktur</h6>
                                        <p>Tanya jawab langsung dengan mentor ahli</p>
                                    </div>
                                </div>

                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="benefit-text">
                                        <h6>Komunitas Eksklusif</h6>
                                        <p>Bergabung dengan grup diskusi siswa</p>
                                    </div>
                                </div>

                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="bi bi-phone"></i>
                                    </div>
                                    <div class="benefit-text">
                                        <h6>Mobile Friendly</h6>
                                        <p>Akses dari smartphone, tablet, atau PC</p>
                                    </div>
                                </div>

                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="bi bi-download"></i>
                                    </div>
                                    <div class="benefit-text">
                                        <h6>Materi Download</h6>
                                        <p>Unduh resource untuk belajar offline</p>
                                    </div>
                                </div>

                                <div class="benefit-item">
                                    <div class="benefit-icon">
                                        <i class="bi bi-speedometer2"></i>
                                    </div>
                                    <div class="benefit-text">
                                        <h6>Belajar Sesuai Ritme</h6>
                                        <p>Tidak ada deadline, belajar sesuai kecepatan Anda</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column (Sidebar) --}}
            <div class="col-lg-4">
                <div class="sidebar-card">
                    {{-- Price Section --}}
                    <div class="price-section">
                        @if ($course->price == 0)
                            <div class="free-badge">
                                <i class="bi bi-gift-fill me-2"></i> GRATIS
                            </div>
                        @else
                            <div class="price-tag">
                                Rp {{ number_format($course->price, 0, ',', '.') }}
                            </div>
                            <p class="price-label">Investasi untuk masa depan Anda</p>
                        @endif
                    </div>

                    {{-- Course Stats --}}
                    <div class="course-stats">
                        <div class="stat-item">
                            <span class="stat-label">
                                <i class="bi bi-collection-play"></i> Total Materi
                            </span>
                            <span class="stat-value">{{ $course->lessons->count() }} Pelajaran</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">
                                <i class="bi bi-clock"></i> Total Durasi
                            </span>
                            <span class="stat-value">{{ $course->lessons->sum('duration') }} Menit</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">
                                <i class="bi bi-bar-chart"></i> Level
                            </span>
                            <span class="stat-value">Semua Level</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">
                                <i class="bi bi-translate"></i> Bahasa
                            </span>
                            <span class="stat-value">Bahasa Indonesia</span>
                        </div>
                    </div>

                    {{-- Action Button --}}
                    @if ($isEnrolled)
                        <button class="btn-enroll" disabled>
                            <i class="bi bi-check-circle-fill"></i> Sudah Terdaftar
                        </button>
                        <a href="{{ route('dashboard.student') }}" class="btn btn-outline-primary w-100 mt-2"
                            style="padding: 0.75rem; border-radius: 12px; font-weight: 600;">
                            <i class="bi bi-arrow-right-circle"></i> Lanjutkan Belajar
                        </a>
                    @else
                        <form action="{{ route('courses.checkout', $course->slug) }}" method="GET">
                            @csrf
                            <button type="submit" class="btn-enroll">
                                <i class="bi bi-bag-check-fill"></i>
                                @if ($course->price == 0)
                                    Daftar Gratis Sekarang
                                @else
                                    Beli Kursus Sekarang
                                @endif
                            </button>
                        </form>
                    @endif


                    {{-- Guarantee Badge --}}
                    <div class="guarantee-badge">
                        <i class="bi bi-shield-check"></i>
                        <span>30 Hari Garansi Uang Kembali</span>
                    </div>

                    {{-- Highlights --}}
                    <div class="mt-4">
                        <h6 class="mb-3" style="font-weight: 700; color: #1f2937;">
                            <i class="bi bi-star-fill text-warning me-2"></i>Highlight Kursus
                        </h6>
                        <ul class="highlights-list">
                            <li><i class="bi bi-check-circle-fill"></i> Materi Lengkap & Terstruktur</li>
                            <li><i class="bi bi-check-circle-fill"></i> Video Berkualitas HD</li>
                            <li><i class="bi bi-check-circle-fill"></i> Studi Kasus Nyata</li>
                            <li><i class="bi bi-check-circle-fill"></i> Support 24/7</li>
                            <li><i class="bi bi-check-circle-fill"></i> Sertifikat Terverifikasi</li>
                        </ul>
                    </div>

                    {{-- Share Section --}}
                    <div class="mt-4 pt-3" style="border-top: 2px solid #f0f0f0;">
                        <p class="text-muted mb-2" style="font-size: 0.85rem; font-weight: 600;">
                            <i class="bi bi-share"></i> Bagikan Kursus Ini
                        </p>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                target="_blank" class="btn btn-sm flex-fill"
                                style="background: #1877f2; color: white; border-radius: 8px; padding: 0.5rem;">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($course->title) }}"
                                target="_blank" class="btn btn-sm flex-fill"
                                style="background: #1da1f2; color: white; border-radius: 8px; padding: 0.5rem;">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($course->title . ' - ' . request()->url()) }}"
                                target="_blank" class="btn btn-sm flex-fill"
                                style="background: #25d366; color: white; border-radius: 8px; padding: 0.5rem;">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            <button onclick="copyLink()" class="btn btn-sm flex-fill"
                                style="background: #6b7280; color: white; border-radius: 8px; padding: 0.5rem;">
                                <i class="bi bi-link-45deg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Footer --}}
@include('layouts.footer_layout')
