@include('layouts.header_landing_page')

@vite(['resources/css/app.css'])

<section class="py-5" style="padding-top: 100px !important;">
    <div class="container">
        <!-- Progress Steps -->
        <div class="checkout-progress">
            <div class="progress-steps">
                <div class="step active">
                    <div class="step-circle">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <span class="step-label">Pilih Kursus</span>
                </div>
                <div class="step active">
                    <div class="step-circle">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <span class="step-label">Pembayaran</span>
                </div>
                <div class="step">
                    <div class="step-circle">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <span class="step-label">Selesai</span>
                </div>
            </div>
        </div>

        <div class="checkout-wrapper">
            <!-- Main Content -->
            <div class="checkout-main">
                <!-- Course Preview -->
                <div class="course-preview">
                    @if ($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="course-thumbnail"
                            alt="{{ $course->title }}">
                    @else
                        <div class="course-thumbnail-placeholder">
                            <i class="bi bi-book"></i>
                        </div>
                    @endif

                    <div class="course-info">
                        <h4>{{ $course->title }}</h4>
                        <p class="text-muted mb-2">{{ Str::limit($course->description, 120) }}</p>
                        <div class="course-meta">
                            <div class="meta-item">
                                <i class="bi bi-person"></i>
                                <span>{{ $course->instructor->name ?? 'Instruktur' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="bi bi-clock"></i>
                                <span>{{ $course->lessons->sum('duration') }} Jam</span>
                            </div>
                            <div class="meta-item">
                                <i class="bi bi-play-circle"></i>
                                <span>{{ $course->lessons->count() }} Pelajaran</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Promo Section -->
                @if ($promos->count() > 0)
                    <div class="promo-section">
                        <div class="promo-header">
                            <div>
                                <div class="promo-badge">
                                    <i class="bi bi-ticket-perforated"></i>
                                    <span>PROMO TERSEDIA</span>
                                </div>
                                <h5 style="margin: 0.75rem 0 0.5rem; font-size: 1.1rem;">Gunakan Kode Promo</h5>
                            </div>
                        </div>
                        <div class="promo-input-group">
                            <input type="text" id="promoCode" class="promo-input" placeholder="Masukkan kode promo">
                            <button type="button" class="btn-view-promo" data-bs-toggle="modal"
                                data-bs-target="#promoModal">
                                <i class="bi bi-gift me-2"></i>Lihat Voucher
                            </button>
                        </div>
                        <div id="promoAlert" class="promo-alert d-none">
                            <i class="bi bi-check-circle-fill"></i>
                            <span></span>
                        </div>
                    </div>
                @endif

                <!-- Payment Methods -->
                <div class="section-title">
                    <i class="bi bi-wallet2"></i>
                    <span>Pilih Metode Pembayaran</span>
                </div>

                <form id="paymentForm">
                    <div class="payment-methods">
                        <div class="payment-option" data-method="qris">
                            <div class="payment-icon">
                                <i class="bi bi-qr-code"></i>
                            </div>
                            <div class="payment-details">
                                <h5>QRIS</h5>
                                <p>Scan QR Code dengan aplikasi e-wallet</p>
                            </div>
                            <input type="radio" name="payment_method" value="qris" class="payment-radio">
                        </div>

                        <div class="payment-option" data-method="transfer">
                            <div class="payment-icon">
                                <i class="bi bi-bank"></i>
                            </div>
                            <div class="payment-details">
                                <h5>Transfer Bank</h5>
                                <p>Transfer ke rekening BCA atau Mandiri</p>
                            </div>
                            <input type="radio" name="payment_method" value="transfer" class="payment-radio">
                        </div>

                        <div class="payment-option" data-method="cash">
                            <div class="payment-icon">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                            <div class="payment-details">
                                <h5>Cash</h5>
                                <p>Bayar langsung di tempat</p>
                            </div>
                            <input type="radio" name="payment_method" value="cash" class="payment-radio">
                        </div>
                    </div>
                </form>

                <a href="{{ route('purchase.detail', $course->slug) }}" class="back-link">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali ke Halaman Kursus</span>
                </a>
            </div>

            <!-- Sidebar Summary -->
            <div class="checkout-sidebar">
                <h3 class="summary-title">Ringkasan Pesanan</h3>

                <div class="summary-item">
                    <span>Harga Kursus</span>
                    <span class="price-value" id="originalPrice">
                        @if ($course->price == 0)
                            Gratis
                        @else
                            Rp {{ number_format($course->price, 0, ',', '.') }}
                        @endif
                    </span>
                </div>

                <div class="summary-item discount d-none" id="discountRow">
                    <span>Diskon Promo</span>
                    <span id="discountAmount">- Rp 0</span>
                </div>

                <div class="summary-item total">
                    <span>Total Pembayaran</span>
                    <span class="price-value total" id="finalPrice">
                        @if ($course->price == 0)
                            Gratis
                        @else
                            Rp {{ number_format($course->price, 0, ',', '.') }}
                        @endif
                    </span>
                </div>

                <button type="submit" form="paymentForm" class="btn-checkout" id="btnCheckout" disabled>
                    <i class="bi bi-lock-fill me-2"></i>Lanjutkan Pembayaran
                </button>

                <div class="security-badge">
                    <i class="bi bi-shield-check"></i>
                    <span>Transaksi Aman & Terpercaya</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Voucher -->
<div class="modal fade" id="promoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-ticket-detailed me-2" style="color: #6366f1;"></i>
                    Pilih Voucher Promo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if ($promos->isEmpty())
                    <p class="text-center text-muted">Tidak ada promo aktif saat ini.</p>
                @else
                    <div class="voucher-list">
                        @foreach ($promos as $promo)
                            <div class="voucher-item"
                                onclick="applyPromo('{{ $promo->code }}', {{ $promo->discount_percentage ?? 0 }}, {{ $promo->discount_amount ?? 0 }})"
                                data-bs-dismiss="modal">
                                <div class="voucher-info">
                                    <h6>{{ $promo->title }}</h6>
                                    <p>
                                        {{ $promo->discount_percentage ? $promo->discount_percentage . '% OFF' : 'Potongan Rp ' . number_format($promo->discount_amount, 0, ',', '.') }}
                                    </p>
                                </div>
                                <span class="voucher-code">{{ strtoupper($promo->code) }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal QRIS -->
<div class="modal fade" id="qrisModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-qr-code me-2" style="color: #6366f1;"></i>
                    Pembayaran via QRIS
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p class="text-muted mb-3">Scan QR code di bawah dengan aplikasi e-wallet Anda</p>
                <div class="qr-container">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode('ORDER-' . uniqid()) }}"
                        alt="QRIS" class="qris-img">
                </div>
                <p class="text-success fw-semibold mb-3">
                    <i class="bi bi-check-circle me-2"></i>
                    Setelah membayar, hubungi admin untuk konfirmasi
                </p>
                <button class="btn btn-success w-100" onclick="sendToWhatsApp('qris')">
                    <i class="bi bi-whatsapp me-2"></i>Sudah Bayar & Kirim ke Admin
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Transfer -->
<div class="modal fade" id="transferModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-bank me-2" style="color: #6366f1;"></i>
                    Transfer Bank
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">Transfer ke salah satu rekening di bawah ini:</p>
                <div class="bank-list">
                    <div class="bank-item">
                        <div class="bank-info">
                            <div class="bank-logo">BCA</div>
                            <div>
                                <strong>PT Technest Academy</strong>
                                <div class="bank-number">1234567890</div>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-primary" onclick="copyText('1234567890')">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <div class="bank-item">
                        <div class="bank-info">
                            <div class="bank-logo" style="color: #ff5e3a;">MDR</div>
                            <div>
                                <strong>PT Technest Academy</strong>
                                <div class="bank-number">9876543210</div>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-primary" onclick="copyText('9876543210')">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
                <button class="btn btn-success w-100 mt-3" onclick="sendToWhatsApp('transfer')">
                    <i class="bi bi-whatsapp me-2"></i>Sudah Bayar & Kirim ke Admin
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let basePrice = {{ $course->price }};
    let finalPrice = basePrice;
    let appliedDiscount = 0;

    // Payment method selection
    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove(
                'selected'));
            this.classList.add('selected');
            this.querySelector('input[type="radio"]').checked = true;
            document.getElementById('btnCheckout').disabled = false;
        });
    });

    // Apply promo function
    function applyPromo(code, percent, fixed) {
        const alertBox = document.getElementById('promoAlert');
        const input = document.getElementById('promoCode');
        input.value = code;

        let discount = 0;
        if (percent > 0) {
            discount = basePrice * (percent / 100);
        } else if (fixed > 0) {
            discount = fixed;
        }

        appliedDiscount = discount;
        finalPrice = Math.max(basePrice - discount, 0);

        // Update UI
        document.getElementById('discountRow').classList.remove('d-none');
        document.getElementById('discountAmount').innerText = '- Rp ' + discount.toLocaleString('id-ID');
        document.getElementById('finalPrice').innerText = 'Rp ' + finalPrice.toLocaleString('id-ID');

        alertBox.classList.remove('d-none');
        alertBox.querySelector('span').innerText =
            `Voucher ${code} berhasil! Hemat Rp ${discount.toLocaleString('id-ID')}`;

        // Add animation
        alertBox.style.animation = 'none';
        setTimeout(() => {
            alertBox.style.animation = 'slideIn 0.5s ease';
        }, 10);
    }

    // Form submission
    const paymentForm = document.getElementById("paymentForm");
    paymentForm.addEventListener("submit", function(e) {
        e.preventDefault();
        const method = document.querySelector('input[name="payment_method"]:checked')?.value;

        if (!method) {
            alert("Silakan pilih metode pembayaran terlebih dahulu.");
            return;
        }

        if (method === "qris") {
            new bootstrap.Modal(document.getElementById("qrisModal")).show();
        } else if (method === "transfer") {
            new bootstrap.Modal(document.getElementById("transferModal")).show();
        } else if (method === "cash") {
            sendToWhatsApp('cash');
        }
    });

    // Process payment
    async function processPayment(method) {
        try {
            const response = await fetch("{{ route('payment.process') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    course_id: "{{ $course->id }}",
                    method: method,
                    amount: finalPrice
                })
            });

            const data = await response.json();
            if (data.success) {
                console.log("Pembayaran tercatat:", data.payment);
                return true;
            } else {
                alert("Gagal mencatat pembayaran!");
                return false;
            }
        } catch (error) {
            console.error("Error:", error);
            alert("Terjadi kesalahan. Silakan coba lagi.");
            return false;
        }
    }

    // Send to WhatsApp
    async function sendToWhatsApp(method) {
        const success = await processPayment(method);
        if (!success) return;

        const phone = "6287890971071";
        const user = "{{ auth()->user()->name ?? 'Pengguna' }}";
        const course = "{{ $course->title }}";
        const price = finalPrice.toLocaleString('id-ID');
        const paymentMethod = method === 'qris' ? 'QRIS' : method === 'transfer' ? 'Transfer Bank' : 'Cash';

        const message =
            `Halo Admin Technest Academy,\n\nSaya *${user}* sudah melakukan pembayaran untuk:\n\n📚 Kursus: *${course}*\n💰 Total: Rp ${price}\n💳 Metode: ${paymentMethod}\n\nMohon dicek dan dikonfirmasi ya. Terima kasih! 🙏`;

        const waLink = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
        window.open(waLink, "_blank");

        // Close modal and redirect
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            const bsModal = bootstrap.Modal.getInstance(modal);
            if (bsModal) bsModal.hide();
        });

        setTimeout(() => {
            window.location.href = "{{ route('payment.success', $course->slug) }}";
        }, 2000);
    }

    // Copy text function
    function copyText(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Nomor rekening berhasil disalin!');
        }).catch(err => {
            console.error('Failed to copy:', err);
        });
    }

    // Add slide-in animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
</script>

@include('layouts.footer_layout')
