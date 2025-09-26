@extends('layouts.dashboard_layout')

@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern">
            <div class="page-title-group">
                <h2>Tambah Materi</h2>
                <p class="page-subtitle">Buat materi pembelajaran baru untuk kursus Anda</p>
            </div>
            <div>
                <a href="{{ route('lessons.index') }}" class="btn-back-modern">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Modern Form Container -->
        <div class="form-container">
            <!-- Form Header -->
            <div class="form-header">
                <h3 class="form-title">
                    <i class="bi bi-plus-circle"></i>
                    Form Tambah Materi
                </h3>
                <p class="form-subtitle">Isi informasi materi dengan lengkap dan benar</p>
            </div>

            <!-- Form Body -->
            <div class="form-body">
                <form action="{{ route('lessons.store') }}" method="POST" id="lessonForm">
                    @csrf

                    <!-- Dynamic Lesson Container -->
                    <div id="lessons-container">
                        <div class="lesson-item" data-lesson-index="0">
                            <div class="lesson-header">
                                <h5 class="lesson-title">
                                    <i class="bi bi-play-circle"></i>
                                    Materi #1
                                </h5>
                                <button type="button" class="btn-remove-lesson" data-target="0" style="display: none;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <!-- Pilih Kursus -->
                            <div class="input-group-modern">
                                <label for="course_id_0" class="input-label">
                                    Pilih Kursus
                                </label>
                                <div class="input-with-icon">
                                    <select name="lessons[0][course_id]" id="course_id_0"
                                        class="input-modern @error('lessons.0.course_id') input-error @enderror" required>
                                        <option value="">Pilih kursus untuk materi ini</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}"
                                                {{ old('lessons.0.course_id') == $course->id ? 'selected' : '' }}>
                                                {{ $course->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-book input-icon"></i>
                                </div>
                                @error('lessons.0.course_id')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Judul Materi -->
                            <div class="input-group-modern">
                                <label for="title_0" class="input-label">
                                    Judul Materi
                                </label>
                                <div class="input-with-icon">
                                    <input type="text" name="lessons[0][title]" id="title_0"
                                        class="input-modern @error('lessons.0.title') input-error @enderror"
                                        placeholder="Masukkan judul materi yang menarik"
                                        value="{{ old('lessons.0.title') }}" required autocomplete="off">
                                    <i class="bi bi-pencil input-icon"></i>
                                </div>
                                @error('lessons.0.title')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Konten Materi -->
                            <div class="input-group-modern">
                                <label for="content_0" class="input-label">
                                    Konten Materi
                                </label>
                                <textarea name="lessons[0][content]" id="content_0" rows="4"
                                    class="input-modern @error('lessons.0.content') input-error @enderror"
                                    placeholder="Masukkan deskripsi atau konten materi pembelajaran">{{ old('lessons.0.content') }}</textarea>
                                @error('lessons.0.content')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- URL Video -->
                            <div class="input-group-modern">
                                <label for="video_url_0" class="input-label">
                                    URL Video (Opsional)
                                </label>
                                <div class="input-with-icon">
                                    <input type="url" name="lessons[0][video_url]" id="video_url_0"
                                        class="input-modern @error('lessons.0.video_url') input-error @enderror"
                                        placeholder="https://youtube.com/watch?v=..."
                                        value="{{ old('lessons.0.video_url') }}" autocomplete="off">
                                    <i class="bi bi-camera-video input-icon"></i>
                                </div>
                                @error('lessons.0.video_url')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted mt-2">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Masukkan URL video dari YouTube, Vimeo, atau platform lainnya
                                </small>
                            </div>

                            <!-- Urutan Materi -->
                            <div class="input-group-modern">
                                <label for="order_0" class="input-label">
                                    Urutan Materi
                                </label>
                                <div class="input-with-icon">
                                    <input type="number" name="lessons[0][order]" id="order_0" min="1"
                                        class="input-modern @error('lessons.0.order') input-error @enderror" placeholder="1"
                                        value="{{ old('lessons.0.order', 1) }}" autocomplete="off">
                                    <i class="bi bi-sort-numeric-up input-icon"></i>
                                </div>
                                @error('lessons.0.order')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted mt-2">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Angka untuk menentukan urutan tampil materi dalam kursus
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Add More Lesson Button -->
                    <div class="add-lesson-container">
                        <button type="button" id="addLessonBtn" class="btn-add-modern">
                            <i class="bi bi-plus-circle"></i>
                            Tambah Materi Lain
                        </button>
                    </div>

                    <!-- Action Buttons -->
                    <div class="btn-group-modern">
                        <button type="reset" class="btn-modern btn-secondary-modern" id="resetBtn">
                            <i class="bi bi-arrow-clockwise"></i>
                            Reset Form
                        </button>
                        <button type="submit" class="btn-modern btn-primary-modern" id="submitBtn">
                            <i class="bi bi-save"></i>
                            Simpan Semua Materi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="mt-4">
            <div class="card border-0 shadow-sm"
                style="border-radius: 16px; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);">
                <div class="card-body p-4">
                    <h6 class="text-primary mb-3">
                        <i class="bi bi-lightbulb me-2"></i>
                        Tips Membuat Materi
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Gunakan judul yang jelas dan deskriptif untuk setiap materi
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Atur urutan materi secara logis dari dasar ke lanjutan
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Sertakan URL video untuk pengalaman belajar yang lebih interaktif
                        </li>
                        <li class="mb-0">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Anda bisa menambah beberapa materi sekaligus dalam satu form
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('lessonForm');
            const submitBtn = document.getElementById('submitBtn');
            const resetBtn = document.getElementById('resetBtn');
            const addLessonBtn = document.getElementById('addLessonBtn');
            const lessonsContainer = document.getElementById('lessons-container');
            let lessonIndex = 1;

            // Add new lesson
            addLessonBtn.addEventListener('click', function() {
                const newLessonHtml = createLessonTemplate(lessonIndex);
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = newLessonHtml;
                const newLessonElement = tempDiv.firstElementChild;

                // Add animation
                newLessonElement.style.opacity = '0';
                newLessonElement.style.transform = 'translateY(20px)';
                lessonsContainer.appendChild(newLessonElement);

                // Trigger animation
                setTimeout(() => {
                    newLessonElement.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                    newLessonElement.style.opacity = '1';
                    newLessonElement.style.transform = 'translateY(0)';
                }, 50);

                updateRemoveButtons();
                lessonIndex++;

                // Scroll to new lesson
                newLessonElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            });

            // Remove lesson functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.btn-remove-lesson')) {
                    const btn = e.target.closest('.btn-remove-lesson');
                    const lessonItem = btn.closest('.lesson-item');

                    // Add remove animation
                    lessonItem.style.transition = 'all 0.5s ease';
                    lessonItem.style.transform = 'translateX(-100%)';
                    lessonItem.style.opacity = '0';

                    setTimeout(() => {
                        lessonItem.remove();
                        updateLessonNumbers();
                        updateRemoveButtons();
                    }, 500);
                }
            });

            // Auto-generate slug and validation for title inputs
            document.addEventListener('input', function(e) {
                if (e.target.name && e.target.name.includes('[title]')) {
                    const title = e.target.value;
                    // You can add slug generation logic here if needed

                    // Visual feedback
                    if (title.trim()) {
                        e.target.classList.remove('input-error');
                        e.target.classList.add('input-success');
                    } else {
                        e.target.classList.remove('input-success');
                    }
                }
            });

            // Form validation
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const lessonItems = document.querySelectorAll('.lesson-item');

                lessonItems.forEach((item, index) => {
                    const courseSelect = item.querySelector('select[name*="course_id"]');
                    const titleInput = item.querySelector('input[name*="title"]');

                    if (!courseSelect.value.trim()) {
                        courseSelect.classList.add('input-error');
                        isValid = false;
                    } else {
                        courseSelect.classList.remove('input-error');
                    }

                    if (!titleInput.value.trim()) {
                        titleInput.classList.add('input-error');
                        isValid = false;
                    } else {
                        titleInput.classList.remove('input-error');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    const firstError = form.querySelector('.input-error');
                    if (firstError) {
                        firstError.focus();
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                } else {
                    submitBtn.classList.add('btn-loading');
                    submitBtn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Menyimpan...';
                }
            });

            // Reset form
            resetBtn.addEventListener('click', function() {
                setTimeout(() => {
                    // Keep only the first lesson
                    const allLessons = lessonsContainer.querySelectorAll('.lesson-item');
                    for (let i = 1; i < allLessons.length; i++) {
                        allLessons[i].remove();
                    }

                    // Reset form validation classes
                    document.querySelectorAll('.input-modern').forEach(input => {
                        input.classList.remove('input-error', 'input-success');
                    });

                    lessonIndex = 1;
                    updateRemoveButtons();
                    updateLessonNumbers();
                }, 100);
            });

            // Helper functions
            // === Helper Functions ===

            // Template untuk lesson baru
            function createLessonTemplate(index) {
                return `
        <div class="lesson-item" data-lesson-index="${index}">
            <div class="lesson-header">
                <h5 class="lesson-title">
                    <i class="bi bi-play-circle"></i>
                    Materi #${index + 1}
                </h5>
                <button type="button" class="btn-remove-lesson" data-target="${index}">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <!-- Pilih Kursus -->
            <div class="input-group-modern">
                <label for="course_id_${index}" class="input-label">Pilih Kursus</label>
                <div class="input-with-icon">
                    <select name="lessons[${index}][course_id]" id="course_id_${index}" class="input-modern" required>

                        ${getCourseOptions()}
                    </select>
                    <i class="bi bi-book input-icon"></i>
                </div>
            </div>

            <!-- Judul Materi -->
            <div class="input-group-modern">
                <label for="title_${index}" class="input-label">Judul Materi</label>
                <div class="input-with-icon">
                    <input type="text" name="lessons[${index}][title]" id="title_${index}"
                        class="input-modern" placeholder="Masukkan judul materi yang menarik" required autocomplete="off">
                    <i class="bi bi-pencil input-icon"></i>
                </div>
            </div>

            <!-- Konten Materi -->
            <div class="input-group-modern">
                <label for="content_${index}" class="input-label">Konten Materi</label>
                <textarea name="lessons[${index}][content]" id="content_${index}" rows="4"
                    class="input-modern" placeholder="Masukkan deskripsi atau konten materi pembelajaran"></textarea>
            </div>

            <!-- URL Video -->
            <div class="input-group-modern">
                <label for="video_url_${index}" class="input-label">URL Video (Opsional)</label>
                <div class="input-with-icon">
                    <input type="url" name="lessons[${index}][video_url]" id="video_url_${index}"
                        class="input-modern" placeholder="https://youtube.com/watch?v=..." autocomplete="off">
                    <i class="bi bi-camera-video input-icon"></i>
                </div>
            </div>

            <!-- Urutan Materi -->
            <div class="input-group-modern">
                <label for="order_${index}" class="input-label">Urutan Materi</label>
                <div class="input-with-icon">
                    <input type="number" name="lessons[${index}][order]" id="order_${index}" min="1"
                        class="input-modern" placeholder="1" value="${index + 1}" autocomplete="off">
                    <i class="bi bi-sort-numeric-up input-icon"></i>
                </div>
            </div>
        </div>
        `;
            }

            // Ambil opsi kursus dari select pertama
            function getCourseOptions() {
                const firstSelect = document.querySelector('#course_id_0');
                if (!firstSelect) return '';
                return firstSelect.innerHTML;
            }

            // Update nomor materi
            function updateLessonNumbers() {
                const items = document.querySelectorAll('.lesson-item');
                items.forEach((item, i) => {
                    const title = item.querySelector('.lesson-title');
                    if (title) title.innerHTML = `<i class="bi bi-play-circle"></i> Materi #${i + 1}`;
                });
            }

            // Tampilkan tombol hapus hanya kalau ada lebih dari 1 lesson
            function updateRemoveButtons() {
                const items = document.querySelectorAll('.lesson-item');
                items.forEach((item, i) => {
                    const btn = item.querySelector('.btn-remove-lesson');
                    if (btn) {
                        btn.style.display = (items.length > 1) ? 'inline-flex' : 'none';
                    }
                });
            }

            // Inisialisasi awal
            updateRemoveButtons();
            updateLessonNumbers();
        });
    </script>
@endpush
