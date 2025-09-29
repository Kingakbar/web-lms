<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($lesson) ? $lesson->title : (isset($quiz) ? $quiz->title : $course->title) }} - Learning Platform
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/quis.css') }}">
    <style>
        /* Enhanced Alert Styles */
        .alert-quiz {
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            border: 1px solid #bbdefb;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .alert-quiz::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #2196f3, #9c27b0);
        }

        .alert-quiz.success {
            background: linear-gradient(135deg, #e8f5e8 0%, #f1f8e9 100%);
            border-color: #4caf50;
            animation: successPulse 2s ease-in-out;
        }

        .alert-quiz.success::before {
            background: linear-gradient(135deg, #4caf50, #8bc34a);
        }

        .alert-quiz.failed {
            background: linear-gradient(135deg, #ffebee 0%, #fce4ec 100%);
            border-color: #f44336;
        }

        .alert-quiz.failed::before {
            background: linear-gradient(135deg, #f44336, #e91e63);
        }

        @keyframes successPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.02);
            }
        }

        /* Score Display */
        .score-display {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .score-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .score-circle.success {
            background: linear-gradient(135deg, #4caf50, #45a049);
        }

        .score-circle.failed {
            background: linear-gradient(135deg, #f44336, #d32f2f);
        }

        .score-circle::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
            animation: shine 3s ease-in-out infinite;
        }

        @keyframes shine {

            0%,
            100% {
                opacity: 0.3;
                transform: rotate(0deg);
            }

            50% {
                opacity: 0.1;
                transform: rotate(180deg);
            }
        }

        /* Success Actions */
        .success-actions {
            margin-top: 1.5rem;
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-certificate {
            background: linear-gradient(135deg, #4caf50, #45a049);
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-certificate::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .btn-certificate:hover {
            background: linear-gradient(135deg, #45a049, #4caf50);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-certificate:hover::before {
            left: 100%;
        }

        .btn-retake {
            background: linear-gradient(135deg, #2196f3, #1976d2);
            color: white;
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
        }

        .btn-retake:hover {
            background: linear-gradient(135deg, #1976d2, #2196f3);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(33, 150, 243, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Congratulations Message */
        .congratulations {
            background: linear-gradient(135deg, #fff3e0 0%, #e8f5e8 100%);
            border: 2px solid #4caf50;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .congratulations::before {
            content: '🎉';
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 2rem;
            animation: bounce 2s infinite;
        }

        .congratulations::after {
            content: '🏆';
            position: absolute;
            top: 10px;
            left: 20px;
            font-size: 2rem;
            animation: bounce 2s infinite 0.5s;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        .congratulations h3 {
            color: #2e7d32;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .congratulations p {
            color: #388e3c;
            margin: 0;
        }

        /* Enhanced Quiz Form */
        .quiz-container {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        /* Certificate Success Animation */
        .certificate-success {
            animation: certificateGlow 3s ease-in-out infinite alternate;
        }

        @keyframes certificateGlow {
            0% {
                box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
            }

            100% {
                box-shadow: 0 8px 25px rgba(76, 175, 80, 0.5);
            }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .success-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-certificate,
            .btn-retake {
                justify-content: center;
                width: 100%;
            }

            .score-display {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }
        }

        /* Loading State */
        .btn-certificate.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-certificate.loading::after {
            content: '';
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 0.5rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
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
