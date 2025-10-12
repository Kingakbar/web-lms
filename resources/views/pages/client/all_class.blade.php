{{-- header --}}
@include('layouts.header_landing_page')
@vite(['resources/css/app.css'])
<!-- Navigation -->
@include('layouts.navbar_layout')

<!-- Mobile Bottom Sheet Overlay -->
<div class="bottom-sheet-overlay" id="bottomSheetOverlay"></div>

<!-- Mobile Bottom Sheet for Courses -->
@include('layouts.mobile_bottom_layout')

<section class="browse-section py-5 mt-5">
    <div class="container-fluid px-4">
        <!-- Breadcrumb dengan tombol Home -->
        <div class="breadcrumb-section mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb-custom">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="breadcrumb-link">
                            <i class="bi bi-house-door-fill"></i>
                            <span>Beranda</span>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="bi bi-chevron-right"></i>
                        <span>Jelajahi Kelas</span>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <!-- SIDEBAR FILTER -->
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="filter-sidebar">
                    <div class="sidebar-header">
                        <div class="header-content">
                            <i class="bi bi-funnel-fill"></i>
                            <h5 class="fw-bold mb-0">Filter</h5>
                        </div>
                        <button class="btn-reset" id="resetFilters">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                    </div>

                    <!-- Category Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                            Kategori
                        </h6>
                        <div class="filter-options">
                            <label class="filter-option">
                                <input type="radio" name="category" value="" checked>
                                <span class="filter-label">Semua Kategori</span>
                                <span class="check-mark"></span>
                            </label>
                            @foreach ($categories as $category)
                                <label class="filter-option">
                                    <input type="radio" name="category" value="{{ $category->slug }}">
                                    <span class="filter-label">{{ $category->name }}</span>
                                    <span class="check-mark"></span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Type Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">
                            <i class="bi bi-bookmark-star-fill"></i>
                            Tipe Kelas
                        </h6>
                        <div class="filter-options">
                            <label class="filter-option checkbox">
                                <input type="checkbox" name="type" value="gratis">
                                <span class="filter-label">
                                    <span class="label-text">Gratis</span>
                                    <span class="badge-free">FREE</span>
                                </span>
                                <span class="check-mark"></span>
                            </label>
                            <label class="filter-option checkbox">
                                <input type="checkbox" name="type" value="berbayar">
                                <span class="filter-label">
                                    <span class="label-text">Berbayar</span>
                                    <span class="badge-premium">PRO</span>
                                </span>
                                <span class="check-mark"></span>
                            </label>
                        </div>
                    </div>

                    <!-- Sort Filter -->
                    <div class="filter-section">
                        <h6 class="filter-title">
                            <i class="bi bi-sort-down"></i>
                            Urutkan
                        </h6>
                        <div class="filter-options">
                            <label class="filter-option">
                                <input type="radio" name="sort" value="terbaru" checked>
                                <span class="filter-label">
                                    <i class="bi bi-lightning-fill sort-icon"></i>
                                    Baru Rilis
                                </span>
                                <span class="check-mark"></span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="sort" value="terpopuler">
                                <span class="filter-label">
                                    <i class="bi bi-fire sort-icon"></i>
                                    Terpopuler
                                </span>
                                <span class="check-mark"></span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="sort" value="termurah">
                                <span class="filter-label">
                                    <i class="bi bi-arrow-down-circle sort-icon"></i>
                                    Harga Terendah
                                </span>
                                <span class="check-mark"></span>
                            </label>
                            <label class="filter-option">
                                <input type="radio" name="sort" value="termahal">
                                <span class="filter-label">
                                    <i class="bi bi-arrow-up-circle sort-icon"></i>
                                    Harga Tertinggi
                                </span>
                                <span class="check-mark"></span>
                            </label>
                        </div>
                    </div>

                    <!-- Tombol Kembali ke Home (Sidebar) -->
                    <div class="filter-section">
                        <a href="{{ route('home') }}" class="btn-back-home-sidebar">
                            <i class="bi bi-arrow-left-circle-fill"></i>
                            <span>Kembali ke Beranda</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- MAIN CONTENT -->
            <div class="col-lg-9 col-md-8">
                <!-- Header Section -->
                <div class="content-header mb-4">
                    <div>
                        <h2 class="page-title">
                            <span class="title-gradient">Jelajahi Kelas</span>
                        </h2>
                        <p class="subtitle">Temukan kursus terbaik sesuai passion kamu</p>
                    </div>
                    <div class="results-count" id="resultsCount">
                        <i class="bi bi-collection"></i>
                        <span>{{ $courses->total() }} kelas</span>
                    </div>
                </div>

                <!-- PROMO SECTION -->
                @if ($promos->count() > 0)
                    <div class="promo-section mb-4">
                        <div class="promo-header">
                            <i class="bi bi-gift-fill"></i>
                            <span>Promo Spesial</span>
                            <div class="promo-shine"></div>
                        </div>
                        <div class="promo-list">
                            @foreach ($promos as $promo)
                                <div class="promo-badge">
                                    <strong>{{ $promo->title }}</strong>
                                    @if ($promo->discount_percentage)
                                        <span class="discount">{{ $promo->discount_percentage }}% OFF</span>
                                    @elseif ($promo->discount_amount)
                                        <span class="discount">Rp
                                            {{ number_format($promo->discount_amount, 0, ',', '.') }} OFF</span>
                                    @endif
                                    <code>{{ $promo->code }}</code>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- COURSES GRID -->
                <div id="coursesContainer" class="courses-grid">
                    @foreach ($courses as $course)
                        <div class="course-card-wrapper">
                            <div class="course-card">
                                <div class="course-thumbnail">
                                    @if ($course->thumbnail)
                                        <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                            alt="{{ $course->title }}">
                                    @else
                                        <div class="thumbnail-placeholder">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    @endif

                                    @if ($course->price == 0)
                                        <span class="course-badge free">
                                            <i class="bi bi-stars"></i>
                                            GRATIS
                                        </span>
                                    @else
                                        <span class="course-badge premium">
                                            <i class="bi bi-gem"></i>
                                            PRO
                                        </span>
                                    @endif

                                    <div class="course-overlay">
                                        <a href="{{ route('purchase.detail', $course->slug) }}" class="btn-view">
                                            <i class="bi bi-eye"></i>
                                            <span>Lihat Detail</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="course-content">
                                    <div class="course-tags">
                                        <span class="tag">
                                            <i class="bi bi-tag-fill"></i>
                                            {{ $course->category->name ?? 'Umum' }}
                                        </span>
                                    </div>

                                    <h5 class="course-title">{{ Str::limit($course->title, 50) }}</h5>
                                    <p class="course-description">{{ Str::limit($course->description, 80) }}</p>

                                    <div class="course-meta">
                                        <div class="meta-item">
                                            <i class="bi bi-person-circle"></i>
                                            <span>{{ $course->instructor->name ?? 'Instruktur' }}</span>
                                        </div>
                                        <div class="meta-item">
                                            <i class="bi bi-clock-history"></i>
                                            <span>{{ $course->lessons->sum('duration') ?? 0 }}j</span>
                                        </div>
                                        @if ($course->reviews->count() > 0)
                                            <div class="meta-item">
                                                <i class="bi bi-star-fill"></i>
                                                <span>{{ number_format($course->reviews->avg('rating'), 1) }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="course-footer">
                                        <div class="course-price">
                                            @if ($course->price == 0)
                                                <span class="price-free">Gratis</span>
                                            @else
                                                <div class="price-wrapper">
                                                    <span class="price-label">Harga</span>
                                                    <span class="price-amount">Rp
                                                        {{ number_format($course->price, 0, ',', '.') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <a href="{{ route('purchase.detail', $course->slug) }}" class="btn-buy">
                                            <i class="bi bi-cart-plus"></i>
                                            <span>Beli</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Loading State -->
                <div id="loadingState" class="loading-state" style="display: none;">
                    <div class="spinner">
                        <div class="spinner-ring"></div>
                        <div class="spinner-ring"></div>
                        <div class="spinner-ring"></div>
                    </div>
                    <p>Memuat kursus...</p>
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="empty-state" style="display: none;">
                    <div class="empty-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h5>Tidak Ada Kursus Ditemukan</h5>
                    <p>Maaf, tidak ada kursus yang sesuai dengan filter Anda.</p>
                    <button class="btn-reset-empty" onclick="document.getElementById('resetFilters').click()">
                        <i class="bi bi-arrow-clockwise"></i>
                        Reset Filter
                    </button>
                </div>

                <!-- PAGINATION -->
                <div id="paginationContainer" class="pagination-wrapper mt-5">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Floating Back to Home Button (Mobile) -->
<a href="{{ route('home') }}" class="btn-back-home-floating" title="Kembali ke Beranda">
    <i class="bi bi-house-heart-fill"></i>
</a>



@include('layouts.footer_layout')
