<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technest Academy - Platform Belajar Online Terdepan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/landing_page.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
</head>

<body>
    <!-- Navigation -->
    @include('layouts.navbar_layout')

    <!-- Mobile Bottom Sheet Overlay -->
    <div class="bottom-sheet-overlay" id="bottomSheetOverlay"></div>

    <!-- Mobile Bottom Sheet for Courses -->
    @include('layouts.mobile_bottom_layout')

    <!-- Hero Section -->
    @include('layouts.hero_layout')

    <!-- Features Section -->
    @include('layouts.feature_layout')

    <!-- Courses Section -->
    <section id="courses" class="section-padding">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center" data-aos="fade-up">
                    <h2 class="display-5 fw-bold mb-3">Kursus <span class="gradient-text">Populer</span></h2>
                    <p class="lead text-muted">Pilih dari ratusan kursus teknologi terlengkap dan terbaru yang
                        dirancang untuk semua level keahlian.</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="row g-4">
                    @forelse ($courses as $course)
                        <div class="col-lg-4 col-md-6" data-aos="fade-up">
                            <div class="course-card shadow-sm rounded overflow-hidden">

                                <!-- Course Image + Rating -->
                                <div class="position-relative">
                                    <div class="course-image">
                                        <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                            alt="{{ $course->title }}" class="course-thumbnail">
                                    </div>
                                    <div
                                        class="course-rating position-absolute top-0 end-0 m-2 px-2 py-1 rounded bg-white shadow-sm d-flex align-items-center">
                                        <i class="bi bi-star-fill text-warning me-1"></i>
                                        <span
                                            class="fw-semibold">{{ number_format($course->reviews->avg('rating') ?? 0, 1) }}</span>
                                    </div>
                                </div>

                                <div class="course-content p-3">
                                    <!-- Meta + Instructor sejajar -->
                                    <div class="course-meta d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            @if (!empty($course->instructor->profile_picture))
                                                <img src="{{ asset('storage/' . $course->instructor->profile_picture) }}"
                                                    alt="{{ $course->instructor->name }}" class="rounded-circle me-2"
                                                    width="40" height="40"
                                                    style="object-fit: cover; object-position: center;">
                                            @else
                                                @php
                                                    $name = $course->instructor->name ?? 'IN';
                                                    $initials = strtoupper(
                                                        substr($name, 0, 1) . substr(strstr($name, ' ') ?: $name, 1, 1),
                                                    );
                                                @endphp
                                                <div
                                                    class="avatar-fallback rounded-circle me-2 d-flex justify-content-center align-items-center">
                                                    <span>{{ $initials }}</span>
                                                </div>
                                            @endif
                                            <small class="text-muted">
                                                {{ $course->instructor->name ?? 'Instruktur' }}
                                            </small>
                                        </div>
                                        <span>
                                            <i
                                                class="bi bi-clock me-1"></i>{{ $course->lessons->sum('duration') ?? '0' }}
                                            Jam
                                        </span>
                                    </div>

                                    <!-- Title -->
                                    <h5 class="fw-semibold mb-2">{{ $course->title }}</h5>

                                    <!-- Description -->
                                    <p class="text-muted small">{{ Str::limit($course->description, 100) }}</p>

                                    <!-- Footer -->
                                    <div class="course-footer d-flex justify-content-between align-items-center mt-3">
                                        <div class="text-primary fw-bold fs-5">
                                            Rp {{ number_format($course->price, 0, ',', '.') }}
                                        </div>
                                        <a href="{{ route('courses.show', $course->slug) }}"
                                            class="btn btn-outline-primary btn-sm rounded-pill">
                                            Join Course
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>



                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">Belum ada kursus tersedia.</p>
                        </div>
                    @endforelse
                </div>

            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="#" class="btn btn-primary btn-lg">
                    <i class="bi bi-grid-3x3-gap me-2"></i>Lihat Semua Kursus
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="stats-item">
                        <div class="stats-number" data-count="50">0</div>
                        <p>Siswa Pertama</p>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="stats-item">
                        <div class="stats-number" data-count="10">0</div>
                        <p>Kursus Awal</p>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="stats-item">
                        <div class="stats-number" data-count="95">0</div>
                        <p>% Tingkat Kepuasan</p>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="stats-item">
                        <div class="stats-number" data-count="5">0</div>
                        <p>Instruktur Aktif</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    @include('layouts.testimonial_layout')



    @include('layouts.footer_layout')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    <script src="{{ asset('assets/js/landing_page.js') }}"></script>
    <script>
        lottie.loadAnimation({
            container: document.getElementById('lottie-businessman'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset('assets/img/Businessman.json') }}'
        });
    </script>
</body>

</html>
