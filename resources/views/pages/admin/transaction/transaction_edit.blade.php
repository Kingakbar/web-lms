@extends('layouts.dashboard_layout')

@section('content')
    <div class="container-fluid px-4">
        <!-- Modern Page Header -->
        <div class="page-header-modern">
            <div class="page-title-group">
                <h2>Edit Transaksi</h2>
                <p class="page-subtitle">Perbarui status transaksi yang sudah ada</p>
            </div>
            <div>
                <a href="{{ route('transactions.index') }}" class="btn-back-modern">
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
                    Form Edit Transaksi
                </h3>
                <p class="form-subtitle">Perbarui status transaksi dengan lengkap dan benar</p>
            </div>

            <!-- Form Body -->
            <div class="form-body">
                <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" id="transactionForm">
                    @csrf
                    @method('PUT')

                    <!-- User -->
                    <div class="input-group-modern">
                        <label class="input-label">Pengguna</label>
                        <div class="input-with-icon">
                            <input type="text" class="input-modern"
                                value="{{ $transaction->enrollment->user->name ?? 'N/A' }}" readonly>
                            <i class="bi bi-person input-icon"></i>
                        </div>
                    </div>

                    <!-- Course -->
                    <div class="input-group-modern">
                        <label class="input-label">Kursus</label>
                        <div class="input-with-icon">
                            <input type="text" class="input-modern"
                                value="{{ $transaction->enrollment->course->title ?? 'N/A' }}" readonly>
                            <i class="bi bi-journal-bookmark input-icon"></i>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="input-group-modern">
                        <label class="input-label">Jumlah Pembayaran</label>
                        <div class="input-with-icon">
                            <input type="text" class="input-modern"
                                value="Rp {{ number_format($transaction->amount, 0, ',', '.') }}" readonly>
                            <i class="bi bi-cash-stack input-icon"></i>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="input-group-modern">
                        <label for="status" class="input-label">Status Transaksi</label>
                        <div class="input-with-icon">
                            <select name="status" id="status"
                                class="input-modern @error('status') input-error @enderror" required>
                                <option value="pending"
                                    {{ old('status', $transaction->status ?? 'pending') == 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="completed"
                                    {{ old('status', $transaction->status ?? 'pending') == 'completed' ? 'selected' : '' }}>
                                    Completed</option>
                                <option value="failed"
                                    {{ old('status', $transaction->status ?? 'pending') == 'failed' ? 'selected' : '' }}>
                                    Failed</option>
                            </select>
                            <i class="bi bi-credit-card input-icon"></i>
                        </div>
                        @error('status')
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
                            Update Transaksi
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
                        Tips Mengedit Transaksi
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Pastikan status sesuai dengan kondisi pembayaran sebenarnya
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Status <b>Paid</b> hanya dipakai jika pembayaran sudah terverifikasi
                        </li>
                        <li class="mb-0">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Jika pembayaran gagal, ubah status ke <b>Failed</b>
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
            const form = document.getElementById('transactionForm');
            const submitBtn = document.getElementById('submitBtn');
            const resetBtn = document.getElementById('resetBtn');
            const statusInput = document.getElementById('status');

            // Validation
            form.addEventListener('submit', function(e) {
                if (!statusInput.value.trim()) {
                    e.preventDefault();
                    statusInput.classList.add('input-error');
                } else {
                    submitBtn.classList.add('btn-loading');
                    submitBtn.textContent = 'Menyimpan...';
                }
            });

            resetBtn.addEventListener('click', function() {
                setTimeout(() => {
                    statusInput.classList.remove('input-error', 'input-success');
                }, 100);
            });

            statusInput.addEventListener('blur', function() {
                if (this.value.trim()) {
                    this.classList.remove('input-error');
                    this.classList.add('input-success');
                } else {
                    this.classList.remove('input-success');
                    this.classList.add('input-error');
                }
            });

            statusInput.addEventListener('input', function() {
                this.classList.remove('input-error');
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
