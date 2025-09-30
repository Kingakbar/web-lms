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
                    Anda belum menyelesaikan kursus apapun. Mulai belajar sekarang untuk mendapatkan sertifikat!
                </p>
                <a href="{{ route('courses.index') }}" class="btn-modern btn-primary-modern mt-3">
                    <i class="fas fa-search me-2"></i>Jelajahi Kursus
                </a>
            </div>
        @else
            <!-- Certificates Grid -->
            <div class="row">
                @foreach ($data as $item)
                    @php
                        $en = $item['enrollment'];
                        $course = $en->course;
                    @endphp

                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="course-card-modern">
                            <!-- Certificate Header -->
                            <div class="course-thumbnail">
                                @if (!empty($course) && $course->thumbnail)
                                    <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}"
                                        class="img-fluid">
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
                                <h5 class="course-card-title">{{ $course->title ?? '-' }}</h5>

                                <!-- Course Meta -->
                                <div class="course-meta mb-3">
                                    <div class="meta-item">
                                        <i class="fas fa-user"></i>
                                        <span>{{ optional($course->instructor)->name ?? 'Instruktur' }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-calendar"></i>
                                        <span>{{ $en->created_at ? $en->created_at->format('d M Y') : '-' }}</span>
                                    </div>
                                </div>

                                <!-- Course Description -->
                                <p class="course-card-description">
                                    {{ Str::limit($course->description ?? '-', 100) }}
                                </p>

                                @if (!$item['isCompleted'])
                                    <!-- Progress Section for Incomplete Courses -->
                                    <div class="progress-section mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="progress-label">Progress Kursus</span>
                                            <span class="progress-percentage">
                                                {{ $item['progress'] }}%
                                            </span>
                                        </div>
                                        <div class="progress-bar-modern"
                                            style="background:#eee;border-radius:8px;overflow:hidden;height:10px;">
                                            <div class="progress-fill-modern"
                                                style="width: {{ $item['progress'] }}%; height:100%; background: linear-gradient(90deg,#60a5fa,#4f46e5);">
                                            </div>
                                        </div>
                                        <p class="progress-text mt-2 small text-muted">
                                            {{ $en->completed_lessons ?? 0 }} dari
                                            {{ $en->lessons_count ?? 0 }} pelajaran selesai
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
                                    <a href="{{ route('certificates.generate', $en->id) }}" class="btn-continue">
                                        <i class="fas fa-download me-2"></i>
                                        Unduh Sertifikat
                                    </a>
                                @else
                                    <!-- Jika route courses_student.index tidak ada, ganti sesuai route project -->
                                    <a href="{{ route('courses_student.index') }}" class="btn-continue"
                                        style="background: linear-gradient(135deg, #f59e0b, #d97706);">
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
        document.addEventListener('DOMContentLoaded', function() {
            // Simple animations for cards
            const cards = document.querySelectorAll('.course-card-modern');
            cards.forEach((card, i) => {
                card.style.opacity = 0;
                card.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    card.style.transition = 'all 450ms ease';
                    card.style.opacity = 1;
                    card.style.transform = 'translateY(0)';
                }, 80 * i);
            });

            // Progress hover glow
            const progressBars = document.querySelectorAll('.progress-fill-modern');
            progressBars.forEach(bar => {
                bar.addEventListener('mouseenter', () => {
                    bar.style.boxShadow = '0 6px 20px rgba(79,70,229,0.18)';
                });
                bar.addEventListener('mouseleave', () => {
                    bar.style.boxShadow = 'none';
                });
            });
        });
    </script>
@endpush
