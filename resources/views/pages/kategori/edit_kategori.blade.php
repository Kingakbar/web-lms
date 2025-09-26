@extends('layouts.dashboard_layout')

@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern">
            <div class="page-title-group">
                <h2>Edit Kategori</h2>
                <p class="page-subtitle">Perbarui informasi kategori yang sudah ada</p>
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
                    <i class="bi bi-pencil-square"></i>
                    Form Edit Kategori
                </h3>
                <p class="form-subtitle">Perbarui data kategori dengan lengkap dan benar</p>
            </div>

            <!-- Form Body -->
            <div class="form-body">
                <form action="{{ route('categories.update', $category->slug) }}" method="POST" id="categoryForm">
                    @csrf
                    @method('PUT')

                    <!-- Nama Kategori Input -->
                    <div class="input-group-modern">
                        <label for="name" class="input-label">
                            Nama Kategori
                        </label>
                        <div class="input-with-icon">
                            <input type="text" name="name" id="name"
                                class="input-modern @error('name') input-error @enderror"
                                placeholder="Masukkan nama kategori yang unik" value="{{ old('name', $category->name) }}"
                                required autocomplete="off">
                            <i class="bi bi-tag input-icon"></i>
                        </div>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug Input -->
                    <div class="input-group-modern">
                        <label for="slug" class="input-label">
                            Slug URL
                        </label>
                        <div class="input-with-icon">
                            <input type="text" name="slug" id="slug"
                                class="input-modern @error('slug') input-error @enderror"
                                placeholder="Slug akan dibuat otomatis atau isi manual"
                                value="{{ old('slug', $category->slug) }}" required autocomplete="off">
                            <i class="bi bi-link-45deg input-icon"></i>
                        </div>
                        @error('slug')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            Slug akan dibuat otomatis dari nama kategori, atau Anda bisa menyesuaikannya
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
                            Update Kategori
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
                        Tips Mengedit Kategori
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
                            Anda bisa menyesuaikan slug jika diperlukan
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

            // Auto-generate slug from name
            nameInput.addEventListener('input', function() {
                const name = this.value;
                const slug = name.toLowerCase()
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

            // Validation
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

            resetBtn.addEventListener('click', function() {
                setTimeout(() => {
                    document.querySelectorAll('.input-modern').forEach(input => {
                        input.classList.remove('input-error', 'input-success');
                    });
                }, 100);
            });

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
        });

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
