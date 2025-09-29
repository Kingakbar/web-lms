@extends('layouts.dashboard_layout')
@section('title', 'Tambah Quiz - Instructor Dashboard')
@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern">
            <div class="page-title-group">
                <h2>Tambah Quiz</h2>
                <p class="page-subtitle">Buat quiz baru untuk menguji pemahaman peserta kursus</p>
            </div>
            <div>
                <a href="{{ route('quizzes.index') }}" class="btn-back-modern">
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
                    <i class="bi bi-question-circle"></i>
                    Form Tambah Quiz
                </h3>
                <p class="form-subtitle">Isi informasi quiz dan pertanyaan dengan lengkap</p>
            </div>

            <!-- Form Body -->
            <div class="form-body">
                <form action="{{ route('quizzes.store') }}" method="POST" id="quizForm">
                    @csrf

                    <!-- Pilih Kursus -->
                    <div class="input-group-modern">
                        <label for="course_id" class="input-label">Kursus</label>
                        <div class="input-with-icon">
                            <select name="course_id" id="course_id"
                                class="input-modern @error('course_id') input-error @enderror" required>
                                <option value="">-- Pilih Kursus --</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="bi bi-journal-text input-icon"></i>
                        </div>
                        @error('course_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Judul Quiz -->
                    <div class="input-group-modern">
                        <label for="title" class="input-label">Judul Quiz</label>
                        <div class="input-with-icon">
                            <input type="text" name="title" id="title"
                                class="input-modern @error('title') input-error @enderror" placeholder="Masukkan judul quiz"
                                value="{{ old('title') }}" required>
                            <i class="bi bi-bookmark-check input-icon"></i>
                        </div>
                        @error('title')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi Quiz -->
                    <div class="input-group-modern">
                        <label for="description" class="input-label">Deskripsi</label>
                        <div class="input-with-icon">
                            <textarea name="description" id="description" rows="3"
                                class="input-modern @error('description') input-error @enderror" placeholder="Tulis deskripsi quiz">{{ old('description') }}</textarea>
                            <i class="bi bi-card-text input-icon"></i>
                        </div>
                        @error('description')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Passing Score -->
                    <div class="input-group-modern">
                        <label for="passing_score" class="input-label">Nilai Minimal Lulus (%)</label>
                        <div class="input-with-icon">
                            <input type="number" name="passing_score" id="passing_score" min="0" max="100"
                                class="input-modern @error('passing_score') input-error @enderror" placeholder="Contoh: 70"
                                value="{{ old('passing_score') }}" required>
                            <i class="bi bi-123 input-icon"></i>
                        </div>
                        @error('passing_score')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pertanyaan Quiz -->
                    <div class="input-group-modern">
                        <label class="input-label">Pertanyaan Quiz</label>
                        <div id="questions-wrapper">
                            <!-- Pertanyaan akan ditambahkan via JS -->
                        </div>
                        <button type="button" class="btn-modern btn-secondary-modern mt-2" id="addQuestionBtn">
                            <i class="bi bi-plus-circle"></i> Tambah Pertanyaan
                        </button>
                    </div>

                    <!-- Action Buttons -->
                    <div class="btn-group-modern mt-4">
                        <button type="reset" class="btn-modern btn-secondary-modern" id="resetBtn">
                            <i class="bi bi-arrow-clockwise"></i>
                            Reset Form
                        </button>
                        <button type="submit" class="btn-modern btn-primary-modern" id="submitBtn">
                            <i class="bi bi-save"></i>
                            Simpan Quiz
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionsWrapper = document.getElementById('questions-wrapper');
            const addQuestionBtn = document.getElementById('addQuestionBtn');

            let questionIndex = 0;

            function addQuestion() {
                const questionHtml = `
            <div class="card border-0 shadow-sm p-3 mb-3 question-item" style="border-radius:12px;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold text-dark mb-0">Pertanyaan ${questionIndex + 1}</h6>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-question">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
                <div class="input-group-modern mb-2">
                    <label>Pertanyaan</label>
                    <input type="text" name="questions[${questionIndex}][question]" class="input-modern"
                        placeholder="Tulis pertanyaan">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <input type="text" name="questions[${questionIndex}][option_a]" class="input-modern"
                            placeholder="Opsi A">
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="text" name="questions[${questionIndex}][option_b]" class="input-modern"
                            placeholder="Opsi B">
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="text" name="questions[${questionIndex}][option_c]" class="input-modern"
                            placeholder="Opsi C">
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="text" name="questions[${questionIndex}][option_d]" class="input-modern"
                            placeholder="Opsi D">
                    </div>
                </div>
                <div class="input-group-modern">
                    <label>Jawaban Benar</label>
                    <select name="questions[${questionIndex}][correct_answer]" class="input-modern">
                        <option value="">-- Pilih --</option>
                        <option value="A">Opsi A</option>
                        <option value="B">Opsi B</option>
                        <option value="C">Opsi C</option>
                        <option value="D">Opsi D</option>
                    </select>
                </div>
            </div>
        `;
                questionsWrapper.insertAdjacentHTML('beforeend', questionHtml);
                questionIndex++;
            }

            // Tambahkan 1 pertanyaan default saat halaman dibuka
            addQuestion();

            // Tambah pertanyaan baru saat tombol diklik
            addQuestionBtn.addEventListener('click', addQuestion);

            // Hapus pertanyaan
            questionsWrapper.addEventListener('click', function(e) {
                if (e.target.closest('.remove-question')) {
                    e.target.closest('.question-item').remove();
                }
            });
        });
    </script>
@endpush
