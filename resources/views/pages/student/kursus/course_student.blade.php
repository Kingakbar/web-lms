@extends('layouts.dashboard_layout')

@section('content')

    {{-- Page Header --}} <div class="page-header-modern mb-4">
        <div class="page-title-group">
            <h2 class="mb-2"> <i class="bi bi-collection-play me-2" style="color: var(--primary-color);"></i>
                Kursus Saya </h2>
            <p class="page-subtitle mb-0">Lanjutkan pembelajaran dan raih sertifikat Anda</p>
        </div>
    </div>

    @if ($enrollments->isEmpty())
        {{-- Empty State --}}
        <div class="empty-state-card">
            <div class="empty-state-icon">
                <i class="bi bi-inbox"></i>
            </div>
            <h4 class="empty-state-title">Belum Ada Kursus</h4>
            <p class="empty-state-text">Anda belum membeli kursus apapun. Mulai eksplorasi dan tingkatkan skill Anda
                sekarang!</p>
            <a href="{{ route('courses.index') }}" class="btn-primary-modern mt-3">
                <i class="bi bi-search me-2"></i>
                Jelajahi Kursus
            </a>
        </div>
    @else
        {{-- Stats Overview --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="mini-stat-card">
                    <div class="mini-stat-icon bg-primary-gradient">
                        <i class="bi bi-book"></i>
                    </div>
                    <div class="mini-stat-content">
                        <h3 class="mini-stat-number">{{ $enrollments->count() }}</h3>
                        <p class="mini-stat-label">Total Kursus</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mini-stat-card">
                    <div class="mini-stat-icon bg-success-gradient">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="mini-stat-content">
                        <h3 class="mini-stat-number">
                            {{ $enrollments->filter(function ($e) {
                                    return $e->lessonCompletions->where('is_completed', true)->count() === $e->course->lessons->count() &&
                                        $e->course->lessons->count() > 0;
                                })->count() }}
                        </h3>
                        <p class="mini-stat-label">Selesai</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mini-stat-card">
                    <div class="mini-stat-icon bg-warning-gradient">
                        <i class="bi bi-award"></i>
                    </div>
                    <div class="mini-stat-content">
                        <h3 class="mini-stat-number">{{ $enrollments->whereNotNull('certificate')->count() }}</h3>
                        <p class="mini-stat-label">Sertifikat</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Course Cards --}}
        <div class="row g-4">
            @foreach ($enrollments as $enrollment)
                @php
                    $course = $enrollment->course;
                    $totalLessons = $course->lessons->count();
                    $completedLessons = $enrollment->lessonCompletions->where('is_completed', true)->count();
                    $progressPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

                    // Check if all lessons are completed
                    $allLessonsCompleted = $totalLessons > 0 && $completedLessons === $totalLessons;

                    // Check if quiz is completed and passed
                    $quizPassed = false;
                    if ($course->quiz) {
                        $quizAttempt = \App\Models\QuizAttempt::where('quiz_id', $course->quiz->id)
                            ->where('user_id', auth()->id())
                            ->latest()
                            ->first();
                        $quizPassed = $quizAttempt && $quizAttempt->passed;
                    }

                    // Course is fully completed if all lessons are done AND (no quiz OR quiz is passed)
                    $courseCompleted = $allLessonsCompleted && (!$course->quiz || $quizPassed);

                    // Tentukan next lesson
                    $lastCompleted = $enrollment->lessonCompletions->where('is_completed', true)->last();
                    $nextLesson = $lastCompleted
                        ? $course->lessons->where('order', '>', $lastCompleted->lesson->order)->sortBy('order')->first()
                        : $course->lessons->first();
                @endphp

                <div class="col-md-6 col-lg-4">
                    <div class="course-card-modern">
                        {{-- Thumbnail --}}
                        <div class="course-thumbnail">
                            @if ($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}">
                            @else
                                <div class="course-thumbnail-placeholder">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif

                            {{-- Status Badge --}}
                            @if ($courseCompleted)
                                <span class="course-badge badge-completed">
                                    <i class="bi bi-check-circle-fill me-1"></i>Selesai
                                </span>
                            @elseif ($progressPercentage > 0)
                                <span class="course-badge badge-progress">
                                    <i class="bi bi-play-circle-fill me-1"></i>Berlangsung
                                </span>
                            @else
                                <span class="course-badge badge-new">
                                    <i class="bi bi-stars me-1"></i>Baru
                                </span>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="course-card-body">
                            {{-- Category & Instructor --}}
                            <div class="course-meta mb-2">
                                <span class="meta-item">
                                    <i class="bi bi-tag"></i>
                                    {{ $course->category->name ?? 'Umum' }}
                                </span>
                                <span class="meta-item">
                                    <i class="bi bi-person"></i>
                                    {{ Str::limit($course->instructor->name ?? '-', 15) }}
                                </span>
                            </div>

                            {{-- Title --}}
                            <h5 class="course-card-title mb-2">{{ Str::limit($course->title, 50) }}</h5>

                            {{-- Description --}}
                            <p class="course-card-description">{{ Str::limit($course->description, 80) }}</p>

                            {{-- Progress Bar --}}
                            <div class="progress-section mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="progress-label">Progress</span>
                                    <span class="progress-percentage">{{ $progressPercentage }}%</span>
                                </div>
                                <div class="progress-bar-modern">
                                    <div class="progress-fill-modern" style="width: {{ $progressPercentage }}%"></div>
                                </div>
                                <p class="progress-text">{{ $completedLessons }} dari {{ $totalLessons }} lesson
                                    selesai</p>
                            </div>

                            {{-- Stats Grid --}}
                            <div class="course-stats-grid mb-3">
                                <div class="stat-item">
                                    <i class="bi bi-play-btn"></i>
                                    <span>{{ $course->lessons->count() }} Lesson</span>
                                </div>
                                <div class="stat-item">
                                    <i class="bi bi-question-circle"></i>
                                    <span>{{ $course->quiz ? '1 Quiz' : '0 Quiz' }}</span>
                                </div>
                                <div class="stat-item">
                                    <i class="bi bi-star-fill"></i>
                                    <span>{{ $course->reviews->count() }} Ulasan</span>
                                </div>
                                @if ($quizPassed)
                                    <div class="stat-item text-success">
                                        <i class="bi bi-award-fill"></i>
                                        <span>Sertifikat</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Action Button --}}
                            @if ($courseCompleted)
                                {{-- Course fully completed --}}
                                <div class="d-flex flex-column gap-2">
                                    <button class="btn-continue"
                                        style="background: linear-gradient(135deg, #10b981, #059669); cursor: default;"
                                        disabled>
                                        <i class="bi bi-trophy-fill me-2"></i>
                                        Kelas Selesai
                                    </button>
                                    @if ($quizPassed)
                                        <a href="{{ route('learn.lesson', [$course->slug, $course->lessons->first()->slug]) }}"
                                            class="btn-continue"
                                            style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                                            <i class="bi bi-arrow-clockwise me-2"></i>
                                            Lihat Kembali Kursus
                                        </a>
                                    @endif
                                </div>
                            @elseif ($allLessonsCompleted && $course->quiz && !$quizPassed)
                                {{-- All lessons done but quiz not passed yet --}}
                                <a href="{{ route('learn.quiz', [$course->slug, $course->quiz->id]) }}"
                                    class="btn-continue" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                                    <i class="bi bi-clipboard-check me-2"></i>
                                    {{ isset($quizAttempt) ? 'Ulangi Quiz' : 'Kerjakan Quiz' }}
                                </a>
                            @elseif ($nextLesson)
                                {{-- Continue with lessons --}}
                                <a href="{{ route('learn.lesson', [$course->slug, $nextLesson->slug]) }}"
                                    class="btn-continue">
                                    <i class="bi bi-play-circle-fill me-2"></i>
                                    {{ $progressPercentage > 0 ? 'Lanjutkan Belajar' : 'Mulai Belajar' }}
                                </a>
                            @elseif ($course->quiz && !$quizPassed)
                                {{-- No more lessons, go to quiz --}}
                                <a href="{{ route('learn.quiz', [$course->slug, $course->quiz->id]) }}"
                                    class="btn-continue">
                                    <i class="bi bi-clipboard-check me-2"></i>
                                    Kerjakan Quiz
                                </a>
                            @else
                                {{-- Fallback: everything completed --}}
                                <button class="btn-continue" style="background: linear-gradient(135deg, #10b981, #059669);"
                                    disabled>
                                    <i class="bi bi-check2-all me-2"></i>
                                    Semua Selesai
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if ($enrollments->hasPages())
            <div class="pagination-modern mt-4">
                {{ $enrollments->onEachSide(1)->links() }}
            </div>
        @endif
    @endif

@endsection

@push('styles')
    <style>
        /* Enhanced button styles for different states */
        .btn-continue:disabled {
            opacity: 0.8;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn-continue:disabled:hover {
            transform: none !important;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3) !important;
        }

        /* Completed course card styling */
        .course-card-modern:has(.btn-continue:disabled[style*="10b981"]) {
            border: 2px solid #10b981;
        }

        .course-card-modern:has(.btn-continue:disabled[style*="10b981"]) .course-thumbnail::after {
            content: '✓';
            position: absolute;
            top: 10px;
            left: 10px;
            width: 30px;
            height: 30px;
            background: #10b981;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
        }

        /* Quiz failed button styling */
        .btn-continue[style*="ef4444"] {
            animation: pulse-red 2s infinite;
        }

        @keyframes pulse-red {

            0%,
            100% {
                box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
            }

            50% {
                box-shadow: 0 4px 20px rgba(239, 68, 68, 0.5);
            }
        }

        /* Certificate download button styling */
        .btn-continue[style*="f59e0b"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4) !important;
        }
    </style>
@endpush
