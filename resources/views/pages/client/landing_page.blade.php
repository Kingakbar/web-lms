{{-- header --}}
@include('layouts.header_landing_page')
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
                <p class="lead text-muted">Pilih dari ratusan kursus teknologi terlengkap dan terbaru yang dirancang
                    untuk semua level keahlian.</p>
            </div>
        </div>

        @if ($promos->isNotEmpty())
            <div class="row justify-content-center mb-4" data-aos="fade-up">
                <div class="col-lg-10">
                    <div class="promo-ticket-container">
                        <div class="promo-ticket">
                            <div class="promo-ticket-left">
                                <div class="promo-badge">
                                    <i class="bi bi-gift-fill"></i>
                                    <span>Promo Terbatas</span>
                                </div>
                                <h3 class="promo-title">{{ $promos->first()->title }}</h3>
                                <div class="promo-code-container">
                                    <div>
                                        <div class="promo-code-label">Kode Promo</div>
                                        <div class="promo-code" id="promoCode">{{ $promos->first()->code }}</div>
                                    </div>
                                    <button class="copy-btn-small" onclick="copyPromoCode()">
                                        <i class="bi bi-clipboard"></i> Salin
                                    </button>
                                </div>
                                <div class="promo-timer">
                                    <i class="bi bi-clock-fill"></i>
                                    <span>Berlaku s/d
                                        {{ \Carbon\Carbon::parse($promos->first()->end_date)->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="promo-ticket-right">
                                <div class="discount-circle">
                                    <div class="discount-value">
                                        @if ($promos->first()->discount_percentage)
                                            {{ $promos->first()->discount_percentage }}%
                                        @else
                                            {{ number_format($promos->first()->discount_amount / 1000, 0) }}K
                                        @endif
                                    </div>
                                    <div class="discount-label">OFF</div>
                                </div>
                                <button class="use-now-btn"
                                    onclick="window.location.href='{{ route('courses.index') }}'">
                                    Gunakan Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function copyPromoCode() {
                    const promoCode = document.getElementById('promoCode').textContent;
                    navigator.clipboard.writeText(promoCode).then(() => {
                        const btn = event.target.closest('.copy-btn-small');
                        const originalHTML = btn.innerHTML;
                        btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Tersalin';
                        btn.style.background = '#10b981';

                        setTimeout(() => {
                            btn.innerHTML = originalHTML;
                            btn.style.background = '#ff6b6b';
                        }, 2000);
                    });
                }
            </script>
        @endif

        <!-- Category Filter Buttons -->
        <div class="row justify-content-center mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-10">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a href="{{ route('home') }}"
                        class="btn category-filter {{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill"
                        data-category="">
                        <i class="bi bi-grid-3x3-gap me-1"></i>Semua Kategori
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('home', ['category' => $category->slug]) }}"
                            class="btn category-filter {{ request('category') == $category->slug ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill"
                            data-category="{{ $category->slug }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Course Cards -->
        <div class="row g-4" id="course-container">
            @forelse ($courses as $course)
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="course-card shadow-sm rounded overflow-hidden">
                        <!-- Course Image + Rating -->
                        <div class="position-relative">
                            <div class="course-image">
                                @if ($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                                        class="course-thumbnail"
                                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="course-placeholder" style="display:none;">
                                        <i class="bi bi-book"></i>
                                        <span>{{ $course->category->name ?? 'Course' }}</span>
                                    </div>
                                @else
                                    <div class="course-placeholder">
                                        <i class="bi bi-book"></i>
                                        <span>{{ $course->category->name ?? 'Course' }}</span>
                                    </div>
                                @endif
                            </div>
                            <div
                                class="course-rating position-absolute top-0 end-0 m-2 px-2 py-1 rounded bg-white shadow-sm d-flex align-items-center">
                                <i class="bi bi-star-fill text-warning me-1"></i>
                                <span
                                    class="fw-semibold">{{ number_format($course->reviews->avg('rating') ?? 0, 1) }}</span>
                            </div>
                        </div>

                        <div class="course-content p-3">
                            <!-- Meta + Instructor -->
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
                                    <i class="bi bi-clock me-1"></i>{{ $course->lessons->sum('duration') ?? '0' }}
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
                                <a href="{{ route('purchase.detail', $course->slug) }}"
                                    class="btn btn-outline-primary btn-sm rounded-pill">
                                    Join Course
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center" data-aos="fade-up">
                    <div class="py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <p class="text-muted mt-3">Belum ada kursus tersedia untuk kategori ini.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- View All Button -->
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('courses.all') }}" class="btn btn-primary btn-lg rounded-pill">
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
