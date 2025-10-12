@include('layouts.header_landing_page')

<div class="success-card">
    <!-- Check Icon -->
    <div class="check-icon">
        <i class="bi bi-check-lg"></i>
    </div>

    <!-- Status Badge -->
    <div class="status-badge">
        <i class="bi bi-clock-history me-1"></i> Menunggu Konfirmasi
    </div>

    <!-- Title -->
    <h1>Pembayaran Berhasil Dikirim!</h1>
    <p class="text-muted">
        Terima kasih telah melakukan pembayaran. Pembayaran Anda sedang dalam proses verifikasi
        oleh tim admin kami. Anda akan menerima notifikasi setelah pembayaran dikonfirmasi.
    </p>

    <!-- Info Box -->
    <div class="info-box">
        <div class="info-item">
            <i class="bi bi-clock"></i>
            <div>
                <h6>Waktu Verifikasi</h6>
                <p>Proses konfirmasi memakan waktu 1-24 jam kerja</p>
            </div>
        </div>
        <div class="info-item">
            <i class="bi bi-bell"></i>
            <div>
                <h6>Notifikasi Otomatis</h6>
                <p>Anda akan mendapat pemberitahuan via WhatsApp dan dashboard</p>
            </div>
        </div>
        <div class="info-item">
            <i class="bi bi-book"></i>
            <div>
                <h6>Akses Kursus</h6>
                <p>Akses kursus akan diaktifkan setelah pembayaran dikonfirmasi</p>
            </div>
        </div>
    </div>

    <!-- Buttons -->
    <div class="d-flex gap-2 justify-content-center mb-3">
        <a href="{{ route('dashboard.student') }}" class="btn btn-primary">
            <i class="bi bi-grid-fill me-2"></i>Ke Dashboard
        </a>
        <a href="{{ route('home') }}" class="btn btn-outline-primary">
            <i class="bi bi-search me-2"></i>Lihat Kursus Lain
        </a>
    </div>

    <!-- Contact Links -->
    <div class="contact-links">
        <small class="text-muted d-block mb-2">Butuh bantuan?</small>
        <a href="https://wa.me/6287890971071" target="_blank">
            <i class="bi bi-whatsapp me-1"></i>WhatsApp
        </a>
        <a href="mailto:support@technest.academy">
            <i class="bi bi-envelope me-1"></i>Email
        </a>
    </div>

    <p class="text-muted mt-4 mb-0" style="font-size: 0.85rem;">
        &copy; {{ date('Y') }} Technest Academy. All rights reserved.
    </p>
</div>
</body>

</html>
