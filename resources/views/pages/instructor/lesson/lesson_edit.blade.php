@extends('layouts.dashboard_layout')
@section('title', 'Edit Materi - Instructor Dashboard')
@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern">
            <div class="page-title-group">
                <h2>Edit Materi</h2>
                <p class="page-subtitle">Ubah atau kelola materi pembelajaran untuk kursus Anda</p>
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
                    <i class="bi bi-pencil-square"></i>
                    Form Edit Materi
                </h3>
                <p class="form-subtitle">Perbarui informasi materi dengan lengkap dan benar</p>
            </div>

            <!-- Form Body -->
            <div class="form-body">
                <form action="{{ route('lessons.update', $lesson->slug) }}" method="POST" id="lessonForm">
                    @csrf
                    @method('PUT')

                    <div class="lesson-item" data-lesson-index="0">
                        <div class="lesson-header">
                            <h5 class="lesson-title">
                                <i class="bi bi-play-circle"></i>
                                Materi
                            </h5>
                        </div>

                        <!-- Pilih Kursus -->
                        <div class="input-group-modern">
                            <label for="course_id_0" class="input-label">Pilih Kursus</label>
                            <div class="input-with-icon">
                                <select name="course_id" id="course_id_0"
                                    class="input-modern @error('course_id') input-error @enderror" required>
                                    <option value="">Pilih kursus untuk materi ini</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            {{ old('course_id', $lesson->course_id) == $course->id ? 'selected' : '' }}>
                                            {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="bi bi-book input-icon"></i>
                            </div>
                            @error('course_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Judul Materi -->
                        <div class="input-group-modern">
                            <label for="title_0" class="input-label">Judul Materi</label>
                            <div class="input-with-icon">
                                <input type="text" name="title" id="title_0"
                                    class="input-modern @error('title') input-error @enderror"
                                    placeholder="Masukkan judul materi yang menarik"
                                    value="{{ old('title', $lesson->title) }}" required autocomplete="off">
                                <i class="bi bi-pencil input-icon"></i>
                            </div>
                            @error('title')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Konten Materi -->
                        <div class="input-group-modern">
                            <label for="content_0" class="input-label">Konten Materi</label>
                            <textarea name="content" id="content_0" rows="4" class="input-modern @error('content') input-error @enderror"
                                placeholder="Masukkan deskripsi atau konten materi pembelajaran">{{ old('content', $lesson->content) }}</textarea>
                            @error('content')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- URL Video -->
                        <div class="input-group-modern">
                            <label for="video_url_0" class="input-label">URL Video (Opsional)</label>
                            <div class="input-with-icon">
                                <input type="url" name="video_url" id="video_url_0"
                                    class="input-modern @error('video_url') input-error @enderror"
                                    placeholder="https://youtube.com/watch?v=..."
                                    value="{{ old('video_url', $lesson->video_url) }}" autocomplete="off">
                                <i class="bi bi-camera-video input-icon"></i>
                            </div>
                            @error('video_url')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted mt-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Masukkan URL video dari YouTube, Vimeo, atau platform lainnya
                            </small>
                        </div>

                        <!-- Urutan Materi -->
                        <div class="input-group-modern">
                            <label for="order_0" class="input-label">Urutan Materi</label>
                            <div class="input-with-icon">
                                <input type="number" name="order" id="order_0" min="1"
                                    class="input-modern @error('order') input-error @enderror" placeholder="1"
                                    value="{{ old('order', $lesson->order) }}" autocomplete="off">
                                <i class="bi bi-sort-numeric-up input-icon"></i>
                            </div>
                            @error('order')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted mt-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Angka untuk menentukan urutan tampil materi dalam kursus
                            </small>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="btn-group-modern">
                        <a href="{{ route('lessons.index') }}" class="btn-modern btn-secondary-modern">
                            <i class="bi bi-arrow-left"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn-modern btn-primary-modern" id="submitBtn">
                            <i class="bi bi-save"></i>
                            Update Materi
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
                        Tips Mengedit Materi
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Pastikan judul tetap jelas dan deskriptif
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Periksa urutan agar materi tampil sesuai alur
                        </li>
                        <li class="mb-0">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Anda bisa memperbarui video, konten, atau kursus sesuai kebutuhan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
