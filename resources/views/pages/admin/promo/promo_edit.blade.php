@extends('layouts.dashboard_layout')

@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern">
            <div class="page-title-group">
                <h2>Edit Promo</h2>
                <p class="page-subtitle">Perbarui detail promo yang sudah ada</p>
            </div>
            <div>
                <a href="{{ route('promos.index') }}" class="btn-back-modern">
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
                    Form Edit Promo
                </h3>
                <p class="form-subtitle">Ubah informasi promo sesuai kebutuhan</p>
            </div>

            <!-- Form Body -->
            <div class="form-body">
                <form action="{{ route('promos.update', $promo->slug) }}" method="POST" id="promoForm">
                    @csrf
                    @method('PUT')

                    <!-- Judul Promo -->
                    <div class="input-group-modern">
                        <label for="title" class="input-label">Judul Promo</label>
                        <div class="input-with-icon">
                            <input type="text" name="title" id="title"
                                class="input-modern @error('title') input-error @enderror"
                                placeholder="Contoh: Diskon Awal Tahun" value="{{ old('title', $promo->title) }}" required>
                            <i class="bi bi-megaphone input-icon"></i>
                        </div>
                        @error('title')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kode Promo -->
                    <div class="input-group-modern">
                        <label for="code" class="input-label">Kode Promo</label>
                        <div class="input-with-icon">
                            <input type="text" name="code" id="code"
                                class="input-modern @error('code') input-error @enderror" placeholder="Contoh: NEWYEAR25"
                                value="{{ old('code', $promo->code) }}" required>
                            <i class="bi bi-upc-scan input-icon"></i>
                        </div>
                        @error('code')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Diskon Persen -->
                    <div class="input-group-modern">
                        <label for="discount_percentage" class="input-label">Diskon (%)</label>
                        <div class="input-with-icon">
                            <input type="number" name="discount_percentage" id="discount_percentage"
                                class="input-modern @error('discount_percentage') input-error @enderror"
                                placeholder="Contoh: 25"
                                value="{{ old('discount_percentage', rtrim(rtrim($promo->discount_percentage, '0'), '.')) }}"
                                min="0" max="100">
                            <i class="bi bi-percent input-icon"></i>
                        </div>
                        @error('discount_percentage')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Kosongkan jika menggunakan nominal diskon.
                        </small>
                    </div>

                    <!-- Diskon Nominal -->
                    <div class="input-group-modern">
                        <label for="discount_amount" class="input-label">Diskon Nominal (Rp)</label>
                        <div class="input-with-icon">
                            <input type="number" name="discount_amount" id="discount_amount"
                                class="input-modern @error('discount_amount') input-error @enderror"
                                placeholder="Contoh: 50000"
                                value="{{ old('discount_amount', rtrim(rtrim($promo->discount_amount, '0'), '.')) }}"
                                min="0">
                            <i class="bi bi-cash-stack input-icon"></i>
                        </div>
                        @error('discount_amount')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Kosongkan jika menggunakan diskon persen.
                        </small>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="input-group-modern">
                        <label for="start_date" class="input-label">Tanggal Mulai</label>
                        <div class="input-with-icon">
                            <input type="date" name="start_date" id="start_date"
                                class="input-modern @error('start_date') input-error @enderror"
                                value="{{ old('start_date', $promo->start_date) }}" required>
                            <i class="bi bi-calendar-event input-icon"></i>
                        </div>
                        @error('start_date')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="input-group-modern">
                        <label for="end_date" class="input-label">Tanggal Selesai</label>
                        <div class="input-with-icon">
                            <input type="date" name="end_date" id="end_date"
                                class="input-modern @error('end_date') input-error @enderror"
                                value="{{ old('end_date', $promo->end_date) }}" required>
                            <i class="bi bi-calendar-check input-icon"></i>
                        </div>
                        @error('end_date')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="btn-group-modern">
                        <button type="reset" class="btn-modern btn-secondary-modern" id="resetBtn">
                            <i class="bi bi-arrow-clockwise"></i>
                            Reset Form
                        </button>
                        <button type="submit" class="btn-modern btn-primary-modern" id="submitBtn">
                            <i class="bi bi-save"></i>
                            Update Promo
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
            const form = document.getElementById('promoForm');
            const submitBtn = document.getElementById('submitBtn');
            const resetBtn = document.getElementById('resetBtn');

            form.addEventListener('submit', function(e) {
                submitBtn.classList.add('btn-loading');
                submitBtn.textContent = 'Menyimpan...';
            });

            resetBtn.addEventListener('click', function() {
                setTimeout(() => {
                    document.querySelectorAll('.input-modern').forEach(input => {
                        input.classList.remove('input-error', 'input-success');
                    });
                }, 100);
            });
        });
    </script>
@endpush
