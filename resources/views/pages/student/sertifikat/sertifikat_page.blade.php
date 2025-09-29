@extends('layouts.dashboard_layout')

@section('content')
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header-modern">
            <div class="page-title-group">
                <h2><i class="fas fa-certificate me-3"></i>Sertifikat Saya</h2>
                <p class="page-subtitle mb-0">Kelola dan unduh sertifikat dari kursus yang telah Anda selesaikan</p>
            </div>
        </div>



        @if ($data->isEmpty())
            <!-- Empty State -->
            <div class="empty-state-card">
                <div class="empty-state-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h3 class="empty-state-title">Belum Ada Sertifikat</h3>
                <p class="empty-state-text">
                    Anda belum mengikuti kursus apapun. Mulai belajar sekarang untuk mendapatkan sertifikat!
                </p>
                <a href="{{ route('courses.index') }}" class="btn-modern btn-primary-modern mt-3">
                    <i class="fas fa-search me-2"></i>Jelajahi Kursus
                </a>
            </div>
        @else
            <!-- Certificates Grid -->
            <div class="row">
                @foreach ($data as $item)
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="course-card-modern">
                            <!-- Certificate Header -->
                            <div class="course-thumbnail">
                                @if ($item['enrollment']->course->thumbnail)
                                    <img src="{{ Storage::url($item['enrollment']->course->thumbnail) }}"
                                        alt="{{ $item['enrollment']->course->title }}" class="img-fluid">
                                @else
                                    <div class="course-thumbnail-placeholder">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                @endif

                                <!-- Status Badge -->
                                <div class="course-badge {{ $item['isCompleted'] ? 'badge-completed' : 'badge-progress' }}">
                                    @if ($item['isCompleted'])
                                        <i class="fas fa-check me-1"></i>Selesai
                                    @else
                                        <i class="fas fa-clock me-1"></i>Progress
                                    @endif
                                </div>
                            </div>

                            <!-- Certificate Body -->
                            <div class="course-card-body">
                                <!-- Course Title -->
                                <h5 class="course-card-title">{{ $item['enrollment']->course->title }}</h5>

                                <!-- Course Meta -->
                                <div class="course-meta mb-3">
                                    <div class="meta-item">
                                        <i class="fas fa-user"></i>
                                        <span>{{ $item['enrollment']->course->instructor->name ?? 'Instruktur' }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-calendar"></i>
                                        <span>{{ $item['enrollment']->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>

                                <!-- Course Description -->
                                <p class="course-card-description">
                                    {{ Str::limit($item['enrollment']->course->description, 100) }}
                                </p>

                                @if (!$item['isCompleted'])
                                    <!-- Progress Section for Incomplete Courses -->
                                    <div class="progress-section mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="progress-label">Progress Kursus</span>
                                            <span class="progress-percentage">
                                                {{ $item['enrollment']->progress_percentage ?? 0 }}%
                                            </span>
                                        </div>
                                        <div class="progress-bar-modern">
                                            <div class="progress-fill-modern"
                                                style="width: {{ $item['enrollment']->progress_percentage ?? 0 }}%"></div>
                                        </div>
                                        <p class="progress-text">
                                            {{ $item['enrollment']->completed_lessons ?? 0 }} dari
                                            {{ $item['enrollment']->course->lessons_count ?? 0 }} pelajaran selesai
                                        </p>
                                    </div>
                                @else
                                    <!-- Certificate Info for Completed Courses -->
                                    <div class="progress-section mb-3">
                                        <div class="d-flex align-items-center justify-content-center text-success">
                                            <i class="fas fa-trophy me-2"></i>
                                            <span class="fw-600">Kursus Selesai!</span>
                                        </div>
                                        <p class="text-center text-muted small mb-0 mt-2">
                                            Selamat! Anda telah menyelesaikan semua pelajaran
                                        </p>
                                    </div>
                                @endif

                                <!-- Action Button -->
                                @if ($item['isCompleted'])
                                    <a href="{{ route('certificates.generate', $item['enrollment']->id) }}"
                                        class="btn-continue">
                                        <i class="fas fa-download me-2"></i>
                                        Unduh Sertifikat
                                    </a>
                                @else
                                    <a href="{{ route('courses_student.index', $item['enrollment']->course->id) }}"
                                        class="btn-continue" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                        <i class="fas fa-play me-2"></i>
                                        Selesaikan Kursus
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on scroll
            const cards = document.querySelectorAll('.course-card-modern');

            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '0';
                        entry.target.style.transform = 'translateY(20px)';
                        entry.target.style.transition = 'all 0.6s ease';

                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, 100);

                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            cards.forEach(card => {
                observer.observe(card);
            });

            // Add click effect to certificate download buttons
            const downloadButtons = document.querySelectorAll('a[href*="certificates.generate"]');
            downloadButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Add loading state
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                    this.style.pointerEvents = 'none';

                    // Reset after 2 seconds (adjust based on your needs)
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.style.pointerEvents = 'auto';
                    }, 2000);
                });
            });

            // Add hover effect to progress bars
            const progressBars = document.querySelectorAll('.progress-fill-modern');
            progressBars.forEach(bar => {
                bar.addEventListener('mouseenter', function() {
                    this.style.boxShadow = '0 0 10px rgba(99, 102, 241, 0.5)';
                });

                bar.addEventListener('mouseleave', function() {
                    this.style.boxShadow = 'none';
                });
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Additional custom styles specific to certificate page */
        .course-card-modern {
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .course-card-modern:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .badge-completed {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        .progress-fill-modern {
            position: relative;
            overflow: hidden;
        }

        .progress-fill-modern::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        .mini-stat-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .mini-stat-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .mini-stat-card:nth-child(3) {
            animation-delay: 0.3s;
        }
    </style>
@endpush
