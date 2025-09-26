@extends('layouts.dashboard_layout')

@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern">
            <div class="page-title-group">
                <h2>Edit Kursus</h2>
                <p class="page-subtitle">Perbarui informasi kursus yang sudah ada</p>
            </div>
            <div>
                <a href="{{ route('courses_instructor.index') }}" class="btn-back-modern">
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
                    Form Edit Kursus
                </h3>
                <p class="form-subtitle">Ubah informasi kursus dengan lengkap dan benar</p>
            </div>

            <!-- Form Body -->
            <div class="form-body">
                <form action="{{ route('courses_instructor.update', $course->slug) }}" method="POST"
                    enctype="multipart/form-data" id="courseForm">
                    @csrf
                    @method('PUT')

                    <!-- Judul Kursus -->
                    <div class="input-group-modern">
                        <label for="title" class="input-label">Judul Kursus</label>
                        <div class="input-with-icon">
                            <input type="text" name="title" id="title"
                                class="input-modern @error('title') input-error @enderror"
                                placeholder="Masukkan judul kursus" value="{{ old('title', $course->title) }}" required
                                autocomplete="off">
                            <i class="bi bi-journal-text input-icon"></i>
                        </div>
                        @error('title')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="input-group-modern">
                        <label for="slug" class="input-label">Slug URL</label>
                        <div class="input-with-icon">
                            <input type="text" name="slug" id="slug"
                                class="input-modern @error('slug') input-error @enderror" placeholder="Slug URL"
                                value="{{ old('slug', $course->slug) }}" required autocomplete="off">
                            <i class="bi bi-link-45deg input-icon"></i>
                        </div>
                        @error('slug')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div class="input-group-modern">
                        <label for="category_id" class="input-label">Kategori</label>
                        <div class="input-with-icon">
                            <select name="category_id" id="category_id"
                                class="input-modern @error('category_id') input-error @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="bi bi-tags-fill input-icon"></i>
                        </div>
                        @error('category_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="input-group-modern">
                        <label for="description" class="input-label">Deskripsi</label>
                        <textarea name="description" id="description" rows="5"
                            class="input-modern @error('description') input-error @enderror" placeholder="Tulis deskripsi kursus">{{ old('description', $course->description) }}</textarea>
                        @error('description')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Harga -->
                    <div class="input-group-modern">
                        <label for="price" class="input-label">Harga (opsional)</label>
                        <div class="input-with-icon">
                            <input type="number" name="price" id="price"
                                class="input-modern @error('price') input-error @enderror"
                                placeholder="Masukkan harga kursus"
                                value="{{ old('price', number_format($course->price, 0, '', '')) }}">
                            <i class="bi bi-cash input-icon"></i>
                        </div>
                        @error('price')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Thumbnail -->
                    <div class="input-group-modern">
                        <label for="thumbnail" class="input-label">Thumbnail</label>
                        <div class="upload-area" id="uploadArea">
                            @if ($course->thumbnail)
                                <div class="upload-preview" id="uploadPreview" style="display:block;">
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Preview"
                                        id="previewImage">
                                    <div class="preview-overlay">
                                        <button type="button" class="btn-remove-preview" id="removePreview">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="upload-content">
                                    <div class="upload-icon">
                                        <i class="bi bi-cloud-upload"></i>
                                    </div>
                                    <div class="upload-text">
                                        <h6 class="upload-title">Drop gambar di sini atau klik untuk browse</h6>
                                        <p class="upload-subtitle">Maksimal 5MB • Format: JPG, PNG, JPEG</p>
                                    </div>
                                </div>
                                <div class="upload-preview" id="uploadPreview" style="display:none;">
                                    <img src="" alt="Preview" id="previewImage">
                                    <div class="preview-overlay">
                                        <button type="button" class="btn-remove-preview" id="removePreview">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="thumbnail" id="thumbnail"
                                class="upload-input @error('thumbnail') input-error @enderror"
                                accept="image/jpeg,image/png,image/jpg,image/webp,image/avif">
                        </div>
                        @error('thumbnail')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="btn-group-modern">
                        <a href="{{ route('courses_instructor.index') }}" class="btn-modern btn-secondary-modern">
                            <i class="bi bi-arrow-left-circle"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn-modern btn-primary-modern" id="submitBtn">
                            <i class="bi bi-save"></i>
                            Update Kursus
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
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');
            const form = document.getElementById('courseForm');
            const submitBtn = document.getElementById('submitBtn');
            const resetBtn = document.getElementById('resetBtn');

            // Auto-generate slug from title
            titleInput.addEventListener('input', function() {
                const title = this.value;
                const slug = title.toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
                slugInput.value = slug;

                if (slug) {
                    slugInput.classList.remove('input-error');
                    slugInput.classList.add('input-success');
                } else {
                    slugInput.classList.remove('input-success');
                }
            });

            // Validation on submit
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const requiredFields = [titleInput, slugInput, document.getElementById('category_id'),
                    document.getElementById('description')
                ];

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('input-error');
                        isValid = false;
                    } else {
                        field.classList.remove('input-error');
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
                    submitBtn.textContent = 'Menyimpan...';
                }
            });

            // Reset form
            resetBtn.addEventListener('click', function() {
                setTimeout(() => {
                    document.querySelectorAll('.input-modern').forEach(input => {
                        input.classList.remove('input-error', 'input-success');
                    });
                }, 100);
            });
        });

        // Animasi saat load
        window.addEventListener('load', function() {
            const elements = document.querySelectorAll('.form-container, .page-header-modern');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const uploadArea = document.getElementById('uploadArea');
            const uploadInput = document.getElementById('thumbnail');
            const uploadPreview = document.getElementById('uploadPreview');
            const previewImage = document.getElementById('previewImage');
            const removePreview = document.getElementById('removePreview');

            // Drag & Drop Events
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                uploadArea.classList.add('dragover');
            }

            function unhighlight() {
                uploadArea.classList.remove('dragover');
            }

            // Handle dropped files
            uploadArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                handleFiles(files);
            }

            // Handle file input change
            uploadInput.addEventListener('change', function() {
                handleFiles(this.files);
            });

            // Handle files
            function handleFiles(files) {
                if (files.length > 0) {
                    const file = files[0];

                    // Validate file type
                    if (!file.type.startsWith('image/')) {
                        showError('File harus berupa gambar (JPG, PNG, JPEG)');
                        return;
                    }

                    // Validate file size (5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        showError('Ukuran file maksimal 5MB');
                        return;
                    }

                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        uploadPreview.style.display = 'block';
                        uploadArea.classList.remove('has-error');
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Remove preview
            removePreview.addEventListener('click', function() {
                uploadInput.value = '';
                uploadPreview.style.display = 'none';
                previewImage.src = '';
            });

            // Show error
            function showError(message) {
                uploadArea.classList.add('has-error');

                // Create or update error message
                let errorDiv = uploadArea.parentNode.querySelector('.error-message');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    uploadArea.parentNode.appendChild(errorDiv);
                }
                errorDiv.textContent = message;

                // Remove error after 5 seconds
                setTimeout(() => {
                    uploadArea.classList.remove('has-error');
                    if (errorDiv) errorDiv.remove();
                }, 5000);
            }
        });
    </script>
@endpush
