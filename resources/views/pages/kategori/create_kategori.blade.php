@extends('layouts.dashboard_layout')



@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern">
            <div class="page-title-group">
                <h2>Tambah Kategori</h2>
                <p class="page-subtitle">Buat kategori baru untuk mengorganisir kursus Anda</p>
            </div>
            <div>
                <a href="{{ route('categories.index') }}" class="btn-back-modern">
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
                    Form Tambah Kategori
                </h3>
                <p class="form-subtitle">Isi informasi kategori dengan lengkap dan benar</p>
            </div>

            <!-- Form Body -->
            <div class="form-body">
                <form action="{{ route('categories.store') }}" method="POST" id="categoryForm">
                    @csrf

                    <!-- Nama Kategori Input -->
                    <div class="input-group-modern">
                        <label for="name" class="input-label">
                            Nama Kategori
                        </label>
                        <div class="input-with-icon">
                            <input type="text" name="name" id="name"
                                class="input-modern @error('name') input-error @enderror"
                                placeholder="Masukkan nama kategori yang unik" value="{{ old('name') }}" required
                                autocomplete="off">
                            <i class="bi bi-tag input-icon"></i>
                        </div>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug Input with Floating Label -->
                    <div class="input-group-modern">
                        <label for="slug" class="input-label">
                            Slug URL
                        </label>
                        <div class="input-with-icon">
                            <input type="text" name="slug" id="slug"
                                class="input-modern @error('slug') input-error @enderror"
                                placeholder="Slug akan dibuat otomatis atau isi manual" value="{{ old('slug') }}" required
                                autocomplete="off">
                            <i class="bi bi-link-45deg input-icon"></i>
                        </div>
                        @error('slug')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            Slug akan dibuat otomatis dari nama kategori, atau Anda bisa mengisi manual
                        </small>
                    </div>

                    <!-- Action Buttons -->
                    <div class="btn-group-modern">
                        <button type="reset" class="btn-modern btn-secondary-modern" id="resetBtn">
                            <i class="bi bi-arrow-clockwise"></i>
                            Reset Form
                        </button>
                        <button type="submit" class="btn-modern btn-primary-modern" id="submitBtn">
                            <i class="bi bi-save"></i>
                            Simpan Kategori
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
                        Tips Membuat Kategori
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Gunakan nama yang deskriptif dan mudah dipahami
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Pastikan nama kategori tidak duplikat dengan yang sudah ada
                        </li>
                        <li class="mb-0">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Slug akan dibuat otomatis, tapi Anda bisa menyesuaikannya
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
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const form = document.getElementById('categoryForm');
            const submitBtn = document.getElementById('submitBtn');
            const resetBtn = document.getElementById('resetBtn');

            // Auto-generate slug from name with enhanced logic
            nameInput.addEventListener('input', function() {
                const name = this.value;
                const slug = name.toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/-+/g, '-') // Replace multiple hyphens with single
                    .replace(/^-|-$/g, ''); // Remove leading/trailing hyphens

                slugInput.value = slug;

                // Add visual feedback
                if (slug) {
                    slugInput.classList.remove('input-error');
                    slugInput.classList.add('input-success');
                } else {
                    slugInput.classList.remove('input-success');
                }
            });

            // Form validation with visual feedback
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const requiredFields = [nameInput, slugInput];

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
                    // Show error message
                    const firstError = form.querySelector('.input-error');
                    if (firstError) {
                        firstError.focus();
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                } else {
                    // Show loading state
                    submitBtn.classList.add('btn-loading');
                    submitBtn.textContent = 'Menyimpan...';
                }
            });

            // Reset form with animation
            resetBtn.addEventListener('click', function() {
                setTimeout(() => {
                    document.querySelectorAll('.input-modern').forEach(input => {
                        input.classList.remove('input-error', 'input-success');
                    });
                }, 100);
            });

            // Real-time validation
            [nameInput, slugInput].forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim()) {
                        this.classList.remove('input-error');
                        this.classList.add('input-success');
                    } else {
                        this.classList.remove('input-success');
                        this.classList.add('input-error');
                    }
                });

                input.addEventListener('input', function() {
                    this.classList.remove('input-error');
                });
            });

            // Prevent slug duplication (you can add AJAX check here)
            slugInput.addEventListener('change', function() {
                const slug = this.value;
                // Here you can add AJAX call to check if slug exists
                // For now, just basic validation
                if (slug && slug.length < 3) {
                    this.classList.add('input-error');
                }
            });
        });

        // Add smooth animations on page load
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
    </script>
@endpush
