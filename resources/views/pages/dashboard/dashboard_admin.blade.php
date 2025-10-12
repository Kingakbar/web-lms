@extends('layouts.dashboard_layout')
@section('content')
    <!-- Welcome Section dengan Gradient Background -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-card fade-in-up">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h3 class="mb-2">Selamat datang, Admin {{ Auth::user()->name }}! 👋</h3>
                        <p class="mb-0">Ini ringkasan aktivitas dan statistik sistem LMS hari ini.</p>
                        <small class="text-light opacity-75">{{ now()->format('l, d F Y') }}</small>
                    </div>
                    <div class="welcome-decoration">
                        <div class="floating-circle circle-1"></div>
                        <div class="floating-circle circle-2"></div>
                        <div class="floating-circle circle-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="enhanced-stats-card fade-in-up" style="animation-delay: 0.1s">
                <div class="card-decoration"></div>
                <div class="d-flex align-items-center">
                    <div class="stats-icon-enhanced bg-primary-gradient">
                        <i class="bi bi-people"></i>
                        <div class="icon-glow"></div>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <div class="stats-number-enhanced">{{ number_format($totalUsers) }}</div>
                        <div class="stats-label-enhanced">Total Pengguna</div>
                        <div class="stats-trend">
                            <i class="bi bi-arrow-up text-success"></i>
                            <span class="text-success">+12%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="enhanced-stats-card fade-in-up" style="animation-delay: 0.2s">
                <div class="card-decoration"></div>
                <div class="d-flex align-items-center">
                    <div class="stats-icon-enhanced bg-success-gradient">
                        <i class="bi bi-journal-text"></i>
                        <div class="icon-glow"></div>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <div class="stats-number-enhanced">{{ number_format($totalCourses) }}</div>
                        <div class="stats-label-enhanced">Total Kursus</div>
                        <div class="stats-trend">
                            <i class="bi bi-arrow-up text-success"></i>
                            <span class="text-success">+8%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="enhanced-stats-card fade-in-up" style="animation-delay: 0.3s">
                <div class="card-decoration"></div>
                <div class="d-flex align-items-center">
                    <div class="stats-icon-enhanced bg-warning-gradient">
                        <i class="bi bi-currency-dollar"></i>
                        <div class="icon-glow"></div>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <div class="stats-number-enhanced">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                        <div class="stats-label-enhanced">Pendapatan</div>
                        <div class="stats-trend">
                            <i class="bi bi-arrow-up text-success"></i>
                            <span class="text-success">+23%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="enhanced-stats-card fade-in-up" style="animation-delay: 0.4s">
                <div class="card-decoration"></div>
                <div class="d-flex align-items-center">
                    <div class="stats-icon-enhanced bg-info-gradient">
                        <i class="bi bi-graph-up-arrow"></i>
                        <div class="icon-glow"></div>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <div class="stats-number-enhanced">{{ $growth > 0 ? '+' : '' }}{{ $growth }}%</div>
                        <div class="stats-label-enhanced">Pertumbuhan</div>
                        <div class="stats-trend">
                            <span class="badge bg-success">Bulan ini</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Recent Activity -->
    <div class="row">
        <!-- Enhanced User Growth Chart -->
        <div class="col-lg-8 mb-4">
            <div class="enhanced-card fade-in-up" style="animation-delay: 0.5s">
                <div class="card-header-enhanced">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title-enhanced mb-1">📈 Grafik Pertumbuhan Pengguna</h5>
                            <small class="text-muted">Trend registrasi pengguna 6 bulan terakhir</small>
                        </div>
                        <div class="chart-controls">
                            <button class="btn btn-sm btn-outline-primary active">6 Bulan</button>
                            <button class="btn btn-sm btn-outline-primary">1 Tahun</button>
                        </div>
                    </div>
                </div>
                <div class="card-body-enhanced">
                    <div class="chart-container">
                        <canvas id="userGrowthChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Latest Transactions -->
        <div class="col-lg-4 mb-4">
            <div class="enhanced-card fade-in-up" style="animation-delay: 0.6s">
                <div class="card-header-enhanced">
                    <h5 class="card-title-enhanced mb-1">💰 Transaksi Terbaru</h5>
                    <small class="text-muted">5 transaksi terakhir</small>
                </div>
                <div class="card-body-enhanced p-0">
                    @forelse ($latestTransactions as $index => $tx)
                        <div class="enhanced-activity-item" style="animation-delay: {{ 0.1 * ($index + 1) }}s">
                            <div class="activity-icon-enhanced bg-success-gradient">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                            <div class="activity-content">
                                <div class="d-flex justify-content-between">
                                    <div class="fw-semibold">Rp {{ number_format($tx->amount, 0, ',', '.') }}</div>
                                    <div class="transaction-status">
                                        <span class="badge bg-success">Lunas</span>
                                    </div>
                                </div>
                                <div class="activity-details">
                                    <small class="text-muted d-block">{{ $tx->enrollment->course->title ?? '-' }}</small>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($tx->paid_at)->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                    <div class="text-center p-3 border-top">
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua Transaksi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Popular Courses -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="enhanced-card fade-in-up" style="animation-delay: 0.7s">
                <div class="card-header-enhanced">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title-enhanced mb-1">🏆 Kursus Populer</h5>
                            <small class="text-muted">Kursus dengan pendaftaran terbanyak</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                Filter
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Minggu ini</a></li>
                                <li><a class="dropdown-item" href="#">Bulan ini</a></li>
                                <li><a class="dropdown-item" href="#">3 Bulan terakhir</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body-enhanced">
                    <div class="table-responsive">
                        <table id="popularCoursesTable" class="table table-striped table-bordered enhanced-table">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="40%">Kursus</th>
                                    <th width="20%">Instruktur</th>
                                    <th width="15%">Enrolled</th>
                                    <th width="20%">Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($popularCourses as $index => $course)
                                    <tr class="table-row-enhanced">
                                        <td>
                                            <div class="rank-badge rank-{{ $index + 1 }}">{{ $index + 1 }}</div>
                                        </td>
                                        <td>
                                            <div class="course-info">
                                                <div class="course-title">{{ $course['title'] }}</div>
                                                <div class="course-category">
                                                    <span class="badge bg-light text-dark">Programming</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="instructor-info">
                                                <div class="instructor-avatar">
                                                    {{ substr($course['instructor'], 0, 2) }}
                                                </div>
                                                <span class="instructor-name">{{ $course['instructor'] }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="enrollment-info">
                                                <strong>{{ $course['enrolled'] }}</strong>
                                                <small class="text-muted d-block">siswa</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="revenue-info">
                                                <strong class="text-success">
                                                    Rp {{ number_format($course['revenue'], 0, ',', '.') }}
                                                </strong>
                                                <div class="revenue-trend">
                                                    @if ($course['growth'] >= 0)
                                                        <i class="bi bi-arrow-up text-success"></i>
                                                        <small class="text-success">+{{ $course['growth'] }}%</small>
                                                    @else
                                                        <i class="bi bi-arrow-down text-danger"></i>
                                                        <small class="text-danger">{{ $course['growth'] }}%</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection



@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            $('#popularCoursesTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                },
                pageLength: 5, // default tampil 5 baris
                ordering: true, // bisa sort
                searching: true, // ada search
                lengthChange: false // disable ubah jumlah row
            });
        });
        const ctx = document.getElementById('userGrowthChart').getContext('2d');

        // Create gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(102, 126, 234, 0.3)');
        gradient.addColorStop(1, 'rgba(102, 126, 234, 0.05)');

        const userGrowthChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($userGrowth, 'month')) !!},
                datasets: [{
                    label: 'Jumlah Pengguna',
                    data: {!! json_encode(array_column($userGrowth, 'count')) !!},
                    borderColor: '#667eea',
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#667eea',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            title: function(context) {
                                return 'Bulan ' + context[0].label;
                            },
                            label: function(context) {
                                return context.parsed.y.toLocaleString('id-ID') + ' pengguna terdaftar';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#64748b',
                            callback: function(value) {
                                return value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    }
                },
                elements: {
                    line: {
                        borderJoinStyle: 'round',
                        borderCapStyle: 'round'
                    }
                }
            }
        });

        // Add hover effects to stats cards
        document.querySelectorAll('.enhanced-stats-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Add click animation to buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                let ripple = document.createElement('span');
                let rect = this.getBoundingClientRect();
                let size = Math.max(rect.width, rect.height);
                let x = e.clientX - rect.left - size / 2;
                let y = e.clientY - rect.top - size / 2;

                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.4);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                `;

                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);

                setTimeout(() => ripple.remove(), 600);
            });
        });

        // Add ripple animation CSS
        const rippleStyle = document.createElement('style');
        rippleStyle.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(rippleStyle);
    </script>
@endpush
