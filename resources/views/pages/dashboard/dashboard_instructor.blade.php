@extends('layouts.dashboard_layout')
@section('title', 'Dashboard Instructor - Technest Academy')
@section('content')
    <!-- Modern Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-card fade-in-up">
                <div class="welcome-content">
                    <div>
                        <h2 class="mb-2 fw-bold">Selamat datang kembali, {{ $instructor->name }}!</h2>
                        <p class="mb-0 opacity-90 fs-5">Mari lihat perkembangan pengajaran Anda hari ini</p>
                    </div>
                    <div class="welcome-decoration d-none d-md-block">
                        <div class="floating-circle circle-1"></div>
                        <div class="floating-circle circle-2"></div>
                        <div class="floating-circle circle-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Stats Cards -->
    <div class="row mb-5">
        <!-- Total Courses -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="enhanced-stats-card fade-in-up" style="animation-delay: 0.1s">
                <div class="card-decoration"></div>
                <div class="d-flex align-items-center">
                    <div class="stats-icon-enhanced bg-primary-gradient">
                        <div class="icon-glow"></div>
                        <i class="bi bi-journal-bookmark"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number-enhanced">{{ $totalCourses }}</div>
                        <div class="stats-label-enhanced">Kursus Aktif</div>
                        <div class="stats-trend">
                            <i class="bi bi-circle-fill text-success" style="font-size: 0.5rem;"></i>
                            <span class="text-success">Siap diakses</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Students -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="enhanced-stats-card fade-in-up" style="animation-delay: 0.2s">
                <div class="card-decoration"></div>
                <div class="d-flex align-items-center">
                    <div class="stats-icon-enhanced bg-success-gradient">
                        <div class="icon-glow"></div>
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number-enhanced">{{ $totalStudents }}</div>
                        <div class="stats-label-enhanced">Total Siswa</div>
                        <div class="stats-trend">
                            <i class="bi bi-heart-fill text-danger" style="font-size: 0.7rem;"></i>
                            <span class="text-muted">Terdaftar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Completion Rate -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="enhanced-stats-card fade-in-up" style="animation-delay: 0.3s">
                <div class="card-decoration"></div>
                <div class="d-flex align-items-center">
                    <div class="stats-icon-enhanced bg-warning-gradient">
                        <div class="icon-glow"></div>
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number-enhanced">{{ $completionRate }}%</div>
                        <div class="stats-label-enhanced">Tingkat Selesai</div>
                        <div class="stats-trend">
                            @if ($completionRate > 0)
                                <i class="bi bi-graph-up text-warning" style="font-size: 0.7rem;"></i>
                                <span class="text-warning">Progress</span>
                            @else
                                <i class="bi bi-dash-circle text-muted" style="font-size: 0.7rem;"></i>
                                <span class="text-muted">Belum ada</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Rating -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="enhanced-stats-card fade-in-up" style="animation-delay: 0.4s">
                <div class="card-decoration"></div>
                <div class="d-flex align-items-center">
                    <div class="stats-icon-enhanced bg-info-gradient">
                        <div class="icon-glow"></div>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number-enhanced">
                            @if ($averageRating > 0)
                                {{ number_format($averageRating, 1) }}
                            @else
                                -
                            @endif
                        </div>
                        <div class="stats-label-enhanced">Rating Rata-rata</div>
                        <div class="stats-trend">
                            @if ($averageRating > 0)
                                @if ($averageRating >= 4.5)
                                    <i class="bi bi-star text-info" style="font-size: 0.7rem;"></i>
                                    <span class="text-info">Excellent</span>
                                @elseif($averageRating >= 4.0)
                                    <i class="bi bi-star text-success" style="font-size: 0.7rem;"></i>
                                    <span class="text-success">Baik</span>
                                @elseif($averageRating >= 3.0)
                                    <i class="bi bi-star text-warning" style="font-size: 0.7rem;"></i>
                                    <span class="text-warning">Cukup</span>
                                @else
                                    <i class="bi bi-star text-danger" style="font-size: 0.7rem;"></i>
                                    <span class="text-danger">Perlu Perbaikan</span>
                                @endif
                            @else
                                <i class="bi bi-dash-circle text-muted" style="font-size: 0.7rem;"></i>
                                <span class="text-muted">Belum ada rating</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="row">
        <!-- Courses Overview - Enhanced -->
        <div class="col-lg-8 mb-4">
            <div class="enhanced-card">
                <div class="card-header-enhanced">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title-enhanced">
                            <i class="bi bi-collection-play me-2 text-primary"></i>
                            Kursus Anda
                        </h5>
                        <a href="{{ route('courses_instructor.index') }}"
                            class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="bi bi-gear me-1"></i>Kelola Semua
                        </a>
                    </div>
                </div>
                <div class="card-body-enhanced">
                    @forelse($courses->take(3) as $index => $course)
                        <div class="modern-course-item mb-4 fade-in-up" style="animation-delay: {{ 0.1 * ($index + 1) }}s">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3">
                                    <div class="course-thumbnail">
                                        @if ($course->thumbnail)
                                            <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                                alt="{{ $course->title }}" class="img-fluid rounded-3">
                                        @else
                                            <div class="default-thumbnail">
                                                <i class="bi bi-play-circle-fill"></i>
                                            </div>
                                        @endif
                                        <div class="course-overlay mt-3">
                                            <span class="badge bg-primary">{{ $course->students_count }} siswa</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9 ps-md-4">
                                    <div class="course-meta">
                                        <h6 class="course-title-modern mb-2">{{ $course->title }}</h6>
                                        <p class="course-description-modern text-muted mb-3">
                                            {{ Str::limit($course->description, 120) }}
                                        </p>
                                        <div class="course-stats">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="stat-item">
                                                        <i class="bi bi-people text-success"></i>
                                                        <span class="ms-1">{{ $course->students_count }} siswa</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="stat-item">
                                                        <i class="bi bi-play-circle text-info"></i>
                                                        <span class="ms-1">{{ $course->lessons_count ?? 0 }}
                                                            materi</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="stat-item">
                                                        <i class="bi bi-calendar text-warning"></i>
                                                        <span
                                                            class="ms-1">{{ $course->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($course->students_count > 0 && isset($course->completion_percentage))
                                            <div class="course-progress mt-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small class="text-muted">Progress Rata-rata Siswa</small>
                                                    <small
                                                        class="text-muted">{{ number_format($course->completion_percentage, 0) }}%</small>
                                                </div>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-gradient"
                                                        style="width: {{ $course->completion_percentage }}%"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state text-center py-5">
                            <i class="bi bi-journal-plus text-muted" style="font-size: 3rem;"></i>
                            <h6 class="mt-3 text-muted">Belum ada kursus</h6>
                            <p class="text-muted">Mulai membuat kursus pertama Anda!</p>

                        </div>
                    @endforelse

                    @if ($courses->count() > 3)
                        <div class="text-center mt-4">
                            <a href="{{ route('courses.index') }}" class="btn btn-outline-primary rounded-pill">
                                Lihat {{ $courses->count() - 3 }} kursus lainnya
                                <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4">
            <!-- Recent Student Activity -->
            <div class="enhanced-card mb-4">
                <div class="card-header-enhanced">
                    <h5 class="card-title-enhanced">
                        <i class="bi bi-activity me-2 text-success"></i>
                        Aktivitas Terkini
                    </h5>
                </div>
                <div class="card-body p-0">
                    @forelse($recentActivities->take(5) as $activity)
                        <div class="enhanced-activity-item">
                            <div class="activity-icon-enhanced bg-success-gradient">
                                <i class="bi bi-person-check"></i>
                            </div>
                            <div class="activity-content">
                                <div class="fw-semibold text-dark">{{ $activity->user->name }}</div>
                                <div class="activity-details">
                                    <small class="text-muted">
                                        Bergabung di <strong>{{ Str::limit($activity->course->title, 25) }}</strong>
                                    </small>
                                    <div class="text-muted small mt-1">
                                        <i class="bi bi-clock me-1"></i>{{ $activity->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center">
                            <i class="bi bi-bell text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2 mb-0">Belum ada aktivitas</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="enhanced-card">
                <div class="card-header-enhanced">
                    <h5 class="card-title-enhanced">
                        <i class="bi bi-lightning-charge me-2 text-warning"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body-enhanced">
                    <div class="d-grid gap-3">
                        <a href="{{ route('courses_instructor.create') }}" class="btn-gradient btn-gradient-primary">
                            <i class="bi bi-plus-circle"></i>
                            Buat Kursus Baru
                        </a>
                        <a href="{{ route('courses_instructor.index') }}" class="btn-gradient btn-gradient-info">
                            <i class="bi bi-gear"></i>
                            Kelola Kursus
                        </a>
                        @if ($totalStudents > 0)
                            <button class="btn-gradient btn-gradient-success" onclick="window.location.href='#'">
                                <i class="bi bi-people"></i>
                                Lihat Siswa ({{ $totalStudents }})
                            </button>
                        @endif
                        <button class="btn-gradient btn-gradient-warning" onclick="window.location.href='#'">
                            <i class="bi bi-chat-dots"></i>
                            Pesan & Diskusi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
