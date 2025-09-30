@extends('layouts.dashboard_layout')

@section('content')
    <!-- Welcome Section with Enhanced Design -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-card fade-in-up">
                <div class="welcome-content">
                    <div>
                        <h2 class="mb-2 fw-bold">Selamat datang kembali, {{ $user->name }}! 👋</h2>
                        <p class="mb-0 opacity-90" style="font-size: 1.1rem;">
                            Anda memiliki <strong>{{ $activeCourses }} kursus aktif</strong> yang sedang berlangsung
                        </p>
                    </div>
                    <div class="welcome-decoration d-none d-md-block">
                        <i class="bi bi-mortarboard" style="font-size: 6rem; opacity: 0.15;"></i>
                    </div>
                </div>
                <!-- Floating circles decoration -->
                <div class="floating-circle circle-1"></div>
                <div class="floating-circle circle-2"></div>
                <div class="floating-circle circle-3"></div>
            </div>
        </div>
    </div>

    <!-- Enhanced Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="enhanced-stats-card fade-in-up" style="animation-delay: 0.1s">
                <div class="card-decoration"></div>
                <div class="d-flex align-items-center">
                    <div class="stats-icon-enhanced bg-primary-gradient">
                        <div class="icon-glow"></div>
                        <i class="bi bi-book-half"></i>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <div class="stats-number-enhanced">{{ $activeCourses }}</div>
                        <div class="stats-label-enhanced">Kursus Aktif</div>
                        <div class="stats-trend text-primary">
                            <i class="bi bi-arrow-up-short"></i>
                            <span style="font-size: 0.75rem; font-weight: 600;">Dalam Progress</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="enhanced-stats-card fade-in-up" style="animation-delay: 0.2s">
                <div class="card-decoration"></div>
                <div class="d-flex align-items-center">
                    <div class="stats-icon-enhanced bg-success-gradient">
                        <div class="icon-glow"></div>
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <div class="stats-number-enhanced">{{ $completedCourses }}</div>
                        <div class="stats-label-enhanced">Diselesaikan</div>
                        <div class="stats-trend text-success">
                            <i class="bi bi-check2"></i>
                            <span style="font-size: 0.75rem; font-weight: 600;">Total Selesai</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="enhanced-stats-card fade-in-up" style="animation-delay: 0.3s">
                <div class="card-decoration"></div>
                <div class="d-flex align-items-center">
                    <div class="stats-icon-enhanced bg-warning-gradient">
                        <div class="icon-glow"></div>
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <div class="stats-number-enhanced">{{ $learningHours }}</div>
                        <div class="stats-label-enhanced">Jam Belajar</div>
                        <div class="stats-trend" style="color: #f5576c;">
                            <i class="bi bi-graph-up"></i>
                            <span style="font-size: 0.75rem; font-weight: 600;">Waktu Total</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="enhanced-stats-card fade-in-up" style="animation-delay: 0.4s">
                <div class="card-decoration"></div>
                <div class="d-flex align-items-center">
                    <div class="stats-icon-enhanced bg-info-gradient">
                        <div class="icon-glow"></div>
                        <i class="bi bi-award-fill"></i>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <div class="stats-number-enhanced">{{ $totalCertificates }}</div>
                        <div class="stats-label-enhanced">Sertifikat</div>
                        <div class="stats-trend" style="color: #00f2fe;">
                            <i class="bi bi-trophy"></i>
                            <span style="font-size: 0.75rem; font-weight: 600;">Pencapaian</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Progress & Activity Feed -->
    <div class="row">
        <!-- Course Progress -->
        <div class="col-lg-8 mb-4">
            <div class="enhanced-card fade-in-up" style="animation-delay: 0.5s">
                <div class="card-header-enhanced">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title-enhanced mb-0">
                            <i class="bi bi-journal-bookmark me-2" style="color: var(--primary-color);"></i>
                            Kursus Berlangsung
                        </h5>
                        <span class="badge bg-primary-soft" style="padding: 8px 16px;">
                            {{ $ongoingCourses->count() }} Kursus
                        </span>
                    </div>
                </div>
                <div class="card-body-enhanced">
                    @forelse ($ongoingCourses as $enrollment)
                        @php
                            $totalLessons = $enrollment->course->lessons->count();
                            $completedLessons = $enrollment->lessonCompletions->where('is_completed', true)->count();
                            $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
                        @endphp
                        <div class="mb-4 p-4 border rounded-4 hover-lift"
                            style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-color: #e5e7eb !important; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0 me-3">
                                            <div
                                                style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.25);">
                                                <i class="bi bi-journal-code" style="font-size: 1.6rem;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-2 fw-bold"
                                                style="color: #1f2937; font-size: 1.15rem; line-height: 1.3;">
                                                {{ $enrollment->course->title }}
                                            </h6>
                                            <p class="text-muted mb-3" style="font-size: 0.9rem; line-height: 1.6;">
                                                {{ Str::limit($enrollment->course->description, 85) }}
                                            </p>
                                            <div class="d-flex gap-3 flex-wrap">
                                                <small class="d-flex align-items-center"
                                                    style="color: #6b7280; font-weight: 500;">
                                                    <span class="d-flex align-items-center justify-content-center me-2"
                                                        style="width: 28px; height: 28px; background: #f3f4f6; border-radius: 8px;">
                                                        <i class="bi bi-book"
                                                            style="font-size: 0.9rem; color: #667eea;"></i>
                                                    </span>
                                                    {{ $totalLessons }} Pelajaran
                                                </small>
                                                <small class="d-flex align-items-center"
                                                    style="color: #059669; font-weight: 600;">
                                                    <span class="d-flex align-items-center justify-content-center me-2"
                                                        style="width: 28px; height: 28px; background: #d1fae5; border-radius: 8px;">
                                                        <i class="bi bi-check-circle-fill" style="font-size: 0.9rem;"></i>
                                                    </span>
                                                    {{ $completedLessons }} Selesai
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center mb-3">
                                        <div style="position: relative; display: inline-block;">
                                            <svg width="110" height="110" style="transform: rotate(-90deg);">
                                                <circle cx="55" cy="55" r="45" fill="none"
                                                    stroke="#f1f5f9" stroke-width="10" />
                                                <circle cx="55" cy="55" r="45" fill="none"
                                                    stroke="url(#gradient{{ $enrollment->id }})" stroke-width="10"
                                                    stroke-dasharray="282.6"
                                                    stroke-dashoffset="{{ 282.6 - (282.6 * $progress) / 100 }}"
                                                    stroke-linecap="round"
                                                    style="filter: drop-shadow(0 2px 4px rgba(102, 126, 234, 0.3));" />
                                                <defs>
                                                    <linearGradient id="gradient{{ $enrollment->id }}" x1="0%"
                                                        y1="0%" x2="100%" y2="100%">
                                                        <stop offset="0%" style="stop-color:#667eea" />
                                                        <stop offset="100%" style="stop-color:#764ba2" />
                                                    </linearGradient>
                                                </defs>
                                            </svg>
                                            <div
                                                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                <div
                                                    style="font-size: 1.75rem; font-weight: 800; background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                                    {{ $progress }}%</div>
                                                <div
                                                    style="font-size: 0.7rem; color: #9ca3af; font-weight: 600; margin-top: -4px;">
                                                    Progress</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('courses_student.show', $enrollment->course->id) }}"
                                        class="btn btn-primary-modern w-100"
                                        style="font-size: 0.95rem; padding: 0.875rem;">
                                        <i class="bi bi-play-circle-fill me-2"></i>
                                        Lanjutkan Belajar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="mb-3" style="font-size: 4rem; color: #e5e7eb;">
                                <i class="bi bi-inbox"></i>
                            </div>
                            <h5 class="text-muted mb-2">Belum Ada Kursus Berlangsung</h5>
                            <p class="text-muted">Mulai perjalanan belajar Anda dengan memilih kursus</p>
                            <a href="{{ route('home') }}" class="btn btn-primary-modern mt-3">
                                <i class="bi bi-search me-2"></i>
                                Jelajahi Kursus
                            </a>
                        </div>
                    @endforelse

                    @if ($ongoingCourses->count() > 0)
                        <div class="text-center mt-4">
                            <a href="{{ route('courses_student.index') }}" class="btn btn-outline-primary"
                                style="border-radius: 20px; padding: 12px 32px; font-weight: 600; border-width: 2px;">
                                <i class="bi bi-grid me-2"></i>
                                Lihat Semua Kursus
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Activity Feed -->
        <div class="col-lg-4 mb-4">
            <div class="enhanced-card fade-in-up" style="animation-delay: 0.6s">
                <div class="card-header-enhanced">
                    <h5 class="card-title-enhanced mb-0">
                        <i class="bi bi-lightning-charge-fill me-2" style="color: #f59e0b;"></i>
                        Aktivitas Terbaru
                    </h5>
                </div>
                <div class="card-body-enhanced p-0">
                    @forelse ($activities as $index => $activity)
                        <div class="enhanced-activity-item" style="animation-delay: {{ 0.1 * $index }}s">
                            <div
                                class="activity-icon-enhanced
                                @if ($activity['type'] == 'quiz') bg-success-gradient
                                @elseif($activity['type'] == 'lesson') bg-primary-gradient
                                @elseif($activity['type'] == 'certificate') bg-info-gradient
                                @else bg-warning-gradient @endif">
                                <i
                                    class="bi
                                    @if ($activity['type'] == 'quiz') bi-check-circle-fill
                                    @elseif($activity['type'] == 'lesson') bi-play-fill
                                    @elseif($activity['type'] == 'certificate') bi-award-fill
                                    @else bi-clock-fill @endif">
                                </i>
                            </div>
                            <div class="activity-content">
                                <div class="fw-semibold" style="color: #1f2937; font-size: 0.95rem;">
                                    {{ $activity['title'] }}
                                </div>
                                <small class="text-muted" style="font-size: 0.8rem;">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $activity['time'] }}
                                </small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="mb-3" style="font-size: 3rem; color: #e5e7eb;">
                                <i class="bi bi-activity"></i>
                            </div>
                            <p class="text-muted mb-0">Belum ada aktivitas terbaru</p>
                            <small class="text-muted">Mulai belajar untuk melihat aktivitas Anda</small>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
