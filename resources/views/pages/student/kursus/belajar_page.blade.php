<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($lesson) ? $lesson->title : (isset($quiz) ? $quiz->title : $course->title) }} - Learning Platform
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    @vite(['resources/css/quis.css'])

</head>

<body>
    <!-- Mobile Toggle Button -->
    <button class="mobile-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars" style="font-size: 1.5rem;"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="course-header">
            <h5><i class="fas fa-book-open"></i> {{ $course->title }}</h5>
            <a href="{{ route('dashboard.student') }}" class="btn-back-dashboard">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Dashboard
            </a>
        </div>

        <div class="lesson-list">
            @php
                $completedLessons = $enrollment->lessonCompletions
                    ->where('is_completed', true)
                    ->pluck('lesson_id')
                    ->toArray();
            @endphp

            <!-- Lesson Items -->
            @foreach ($course->lessons->sortBy('order') as $l)
                <a href="{{ route('learn.lesson', [$course->slug, $l->slug]) }}"
                    class="lesson-item {{ isset($lesson) && $lesson->id === $l->id ? 'active' : '' }}">
                    <div class="lesson-content-wrapper">
                        <span class="lesson-number">{{ $l->order }}</span>
                        <span class="lesson-title">{{ $l->title }}</span>
                    </div>
                    @if (in_array($l->id, $completedLessons))
                        <i class="fas fa-check-circle check-icon"></i>
                    @endif
                </a>
            @endforeach

            <!-- Quiz Item -->
            @if ($course->quiz)
                <a href="{{ route('learn.quiz', [$course->slug, $course->quiz->id]) }}"
                    class="lesson-item quiz-item {{ isset($quiz) && $quiz->id === $course->quiz->id ? 'active' : '' }}">
                    <div class="lesson-content-wrapper">
                        <span class="lesson-number"><i class="fas fa-clipboard-question"></i></span>
                        <span class="lesson-title">Quiz Akhir</span>
                    </div>
                    @if (isset($quizAttempt) && $quizAttempt->passed)
                        <i class="fas fa-check-circle check-icon"></i>
                    @endif
                </a>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-card">
            <!-- Lesson Content -->
            @isset($lesson)
                <h1 class="content-title">{{ $lesson->title }}</h1>

                <!-- Video Player -->
                @if ($lesson->video_url)
                    @php
                        $videoUrl = $lesson->video_url;
                        if (Str::contains($videoUrl, 'youtube.com/watch?v=')) {
                            parse_str(parse_url($videoUrl, PHP_URL_QUERY), $ytParams);
                            $videoId = $ytParams['v'] ?? null;
                            if ($videoId) {
                                $videoUrl = 'https://www.youtube.com/embed/' . $videoId;
                            }
                        }
                        if (Str::contains($videoUrl, 'youtu.be')) {
                            $videoId = last(explode('/', $videoUrl));
                            if ($videoId) {
                                $videoUrl = 'https://www.youtube.com/embed/' . $videoId;
                            }
                        }
                    @endphp
                    <div class="video-wrapper">
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $videoUrl }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                @endif

                <!-- Lesson Text Content -->
                <div class="lesson-content">
                    {!! $lesson->content !!}
                </div>

                <!-- Navigation -->
                @php
                    $lessons = $course->lessons->sortBy('order');
                    $prev = $lessons->where('order', '<', $lesson->order)->sortByDesc('order')->first();
                    $next = $lessons->where('order', '>', $lesson->order)->sortBy('order')->first();
                @endphp

                <div class="navigation-wrapper">
                    @if ($prev)
                        <a href="{{ route('learn.lesson', [$course->slug, $prev->slug]) }}" class="btn-nav btn-prev">
                            <i class="fas fa-arrow-left"></i>
                            {{ $prev->title }}
                        </a>
                    @else
                        <span></span>
                    @endif

                    @if ($next)
                        <form action="{{ route('learn.lesson.complete', [$course->slug, $lesson->slug]) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-nav btn-next">
                                {{ $next->title }}
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('learn.lesson.complete', [$course->slug, $lesson->slug]) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-nav btn-complete">
                                <i class="fas fa-check-circle"></i>
                                Tandai Selesai
                            </button>
                        </form>
                    @endif
                </div>
            @endisset

            <!-- Quiz Content -->
            @isset($quiz)
                <h1 class="content-title"><i class="fas fa-clipboard-question"></i> {{ $quiz->title }}</h1>

                <div class="quiz-description">
                    <p style="margin: 0;"><strong>Deskripsi:</strong> {{ $quiz->description }}</p>
                    <p style="margin: 0.5rem 0 0 0; color: #666;"><strong>Nilai Lulus:</strong> {{ $quiz->passing_score }}%
                    </p>
                </div>

                @if ($quizAttempt)
                    <!-- Congratulations Message for Passed Quiz -->
                    @if ($quizAttempt->passed)
                        <div class="congratulations">
                            <h3><i class="fas fa-trophy"></i> Selamat!</h3>
                            <p>Anda telah berhasil menyelesaikan quiz dengan baik!</p>
                        </div>
                    @endif

                    <!-- Quiz Result Alert -->
                    <div class="alert-quiz {{ $quizAttempt->passed ? 'success' : 'failed' }}">
                        <div class="score-display">
                            <div class="score-circle {{ $quizAttempt->passed ? 'success' : 'failed' }}">
                                {{ $quizAttempt->score }}%
                            </div>
                            <div>
                                <strong><i class="fas fa-chart-line"></i> Skor terakhir kamu:
                                    {{ $quizAttempt->score }}%</strong><br>
                                <span style="color: {{ $quizAttempt->passed ? '#4caf50' : '#f44336' }}; font-weight: 600;">
                                    @if ($quizAttempt->passed)
                                        <i class="fas fa-check-circle"></i> Selamat! Anda LULUS
                                    @else
                                        <i class="fas fa-times-circle"></i> Maaf, Anda TIDAK LULUS
                                    @endif
                                </span>
                                @if (!$quizAttempt->passed)
                                    <br><small style="color: #666; margin-top: 0.5rem; display: block;">
                                        Nilai minimum untuk lulus adalah {{ $quiz->passing_score }}%. Silakan coba lagi!
                                    </small>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="success-actions">
                            @if ($quizAttempt->passed)
                                <!-- Certificate Download Button -->
                                @php
                                    // Check if user has enrollment for this course
                                    $userEnrollment = \App\Models\Enrollment::where('course_id', $course->id)
                                        ->where('user_id', auth()->id())
                                        ->first();
                                @endphp

                                @if ($userEnrollment)
                                    <a href="{{ route('certificates.generate', $userEnrollment->id) }}"
                                        class="btn-certificate certificate-success"
                                        onclick="handleCertificateDownload(this)">
                                        <i class="fas fa-download"></i>
                                        Download Sertifikat
                                    </a>
                                @endif

                                <a href="{{ route('dashboard.student') }}" class="btn-retake">
                                    <i class="fas fa-home"></i>
                                    Kembali ke Dashboard
                                </a>
                            @else
                                <!-- Retake Quiz Button -->
                                <button type="button" class="btn-retake" onclick="retakeQuiz()">
                                    <i class="fas fa-redo"></i>
                                    Coba Lagi
                                </button>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Quiz Form -->
                <div class="quiz-container">
                    <form action="{{ route('learn.quiz.submit', [$course->slug, $quiz->id]) }}" method="POST"
                        id="quiz-form">
                        @csrf
                        @foreach ($quiz->questions as $index => $q)
                            <div class="quiz-question">
                                <p style="font-weight: 700; font-size: 1.1rem; margin-bottom: 1rem;">
                                    <span class="question-number">{{ $index + 1 }}</span>
                                    {{ $q->question }}
                                </p>
                                <div class="quiz-options">
                                    <label class="option-label">
                                        <input type="radio" name="answers[{{ $q->id }}]" value="A" required>
                                        <span>A. {{ $q->option_a }}</span>
                                    </label>
                                    <label class="option-label">
                                        <input type="radio" name="answers[{{ $q->id }}]" value="B"
                                            required>
                                        <span>B. {{ $q->option_b }}</span>
                                    </label>
                                    <label class="option-label">
                                        <input type="radio" name="answers[{{ $q->id }}]" value="C"
                                            required>
                                        <span>C. {{ $q->option_c }}</span>
                                    </label>
                                    <label class="option-label">
                                        <input type="radio" name="answers[{{ $q->id }}]" value="D"
                                            required>
                                        <span>D. {{ $q->option_d }}</span>
                                    </label>
                                </div>
                            </div>
                        @endforeach

                        <button type="submit" class="btn-submit-quiz">
                            <i class="fas fa-paper-plane"></i> Kumpulkan Jawaban
                        </button>
                    </form>
                </div>
            @endisset
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar for mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-toggle');

            if (window.innerWidth <= 768 &&
                !sidebar.contains(e.target) &&
                !toggle.contains(e.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // Animate quiz questions on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });

        document.querySelectorAll('.quiz-question').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.5s ease';
            observer.observe(el);
        });

        // Handle certificate download
        function handleCertificateDownload(button) {
            // Add loading state
            button.classList.add('loading');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

            // Reset after 3 seconds (certificate should load by then)
            setTimeout(() => {
                button.classList.remove('loading');
                button.innerHTML = originalText;
            }, 3000);
        }

        // Retake quiz function
        function retakeQuiz() {
            if (confirm('Apakah Anda yakin ingin mengulang quiz? Skor sebelumnya akan tetap tersimpan.')) {
                // Scroll to quiz form
                document.getElementById('quiz-form').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                // Clear all radio buttons
                document.querySelectorAll('input[type="radio"]').forEach(radio => {
                    radio.checked = false;
                });

                // Focus on first question
                const firstRadio = document.querySelector('input[type="radio"]');
                if (firstRadio) {
                    firstRadio.focus();
                }
            }
        }

        // Auto scroll to result if quiz was just submitted
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(() => {
                    const alertQuiz = document.querySelector('.alert-quiz');
                    if (alertQuiz) {
                        alertQuiz.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }, 500);
            });
        @endif

        // Confetti effect for passed quiz
        @if (isset($quizAttempt) && $quizAttempt->passed)
            document.addEventListener('DOMContentLoaded', function() {
                // Simple confetti effect using CSS animations
                createConfetti();
            });

            function createConfetti() {
                const colors = ['#f43f5e', '#8b5cf6', '#06b6d4', '#10b981', '#f59e0b'];
                const confettiCount = 50;

                for (let i = 0; i < confettiCount; i++) {
                    const confetti = document.createElement('div');
                    confetti.style.position = 'fixed';
                    confetti.style.width = '10px';
                    confetti.style.height = '10px';
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.left = Math.random() * 100 + 'vw';
                    confetti.style.top = '-10px';
                    confetti.style.zIndex = '9999';
                    confetti.style.pointerEvents = 'none';
                    confetti.style.borderRadius = '2px';

                    document.body.appendChild(confetti);

                    // Animate confetti falling
                    confetti.animate([{
                            transform: 'translateY(0) rotate(0deg)',
                            opacity: 1
                        },
                        {
                            transform: `translateY(100vh) rotate(720deg)`,
                            opacity: 0
                        }
                    ], {
                        duration: 3000 + Math.random() * 2000,
                        easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
                    }).onfinish = () => confetti.remove();
                }
            }
        @endif
    </script>
</body>

</html>
