@extends('layouts.dashboard_layout')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header dengan Gradient --}}
        <div class="stats-header mb-5">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h1 class="display-6 fw-bold mb-2">
                        <i class="bi bi-graph-up-arrow me-2 text-primary"></i>
                        Statistik Progress
                    </h1>
                    <p class="text-muted mb-0">Pantau perkembangan belajar Anda secara real-time</p>
                </div>
                <div class="stats-date-badge">
                    <i class="bi bi-calendar3 me-2"></i>
                    <span id="currentDate"></span>
                </div>
            </div>
        </div>

        {{-- Statistik Cards dengan Animasi --}}
        <div class="row g-4 mb-5">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-primary">
                    <div class="stat-card-overlay"></div>
                    <div class="stat-card-content">
                        <div class="stat-icon-wrapper">
                            <div class="stat-icon">
                                <i class="bi bi-journals"></i>
                            </div>
                        </div>
                        <div class="stat-info">
                            <h2 class="stat-number">{{ $totalCourses }}</h2>
                            <p class="stat-label">Total Kursus</p>
                            <div class="stat-trend">
                                <i class="bi bi-arrow-up"></i> Aktif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-success">
                    <div class="stat-card-overlay"></div>
                    <div class="stat-card-content">
                        <div class="stat-icon-wrapper">
                            <div class="stat-icon">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                        </div>
                        <div class="stat-info">
                            <h2 class="stat-number">{{ $completedCourses }}</h2>
                            <p class="stat-label">Kursus Selesai</p>
                            <div class="stat-trend success">
                                <i class="bi bi-trophy-fill"></i> Luar Biasa!
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-warning">
                    <div class="stat-card-overlay"></div>
                    <div class="stat-card-content">
                        <div class="stat-icon-wrapper">
                            <div class="stat-icon">
                                <i class="bi bi-award-fill"></i>
                            </div>
                        </div>
                        <div class="stat-info">
                            <h2 class="stat-number">{{ $certificates }}</h2>
                            <p class="stat-label">Sertifikat</p>
                            <div class="stat-trend warning">
                                <i class="bi bi-star-fill"></i> Pencapaian
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-info">
                    <div class="stat-card-overlay"></div>
                    <div class="stat-card-content">
                        <div class="stat-icon-wrapper">
                            <div class="stat-icon">
                                <i class="bi bi-graph-up"></i>
                            </div>
                        </div>
                        <div class="stat-info">
                            <h2 class="stat-number">{{ $avgProgress }}%</h2>
                            <p class="stat-label">Rata-rata Progress</p>
                            <div class="stat-trend info">
                                <i class="bi bi-lightning-fill"></i> Terus Maju!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Progress Bar Global --}}
        <div class="row mb-5">
            <div class="col-12">
                <div class="global-progress-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h5 class="mb-1 fw-bold">Progress Global Anda</h5>
                            <p class="text-muted small mb-0">Menyelesaikan {{ $completedCourses }} dari {{ $totalCourses }}
                                kursus</p>
                        </div>
                        <div class="progress-percentage">
                            <span class="display-6 fw-bold text-white">{{ $avgProgress }}%</span>
                        </div>
                    </div>
                    <div class="modern-progress-bar">
                        <div class="modern-progress-fill" style="width: {{ $avgProgress }}%">
                            <div class="progress-glow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik Section --}}
        <div class="row g-4">
            <div class="col-xl-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <h5 class="mb-1 fw-bold">
                                <i class="bi bi-pie-chart-fill me-2 text-primary"></i>
                                Status Kursus
                            </h5>
                            <p class="text-muted small mb-0">Distribusi status pembelajaran</p>
                        </div>
                    </div>
                    <div class="chart-body">
                        <canvas id="courseStatusChart"></canvas>
                    </div>
                    <div class="chart-legend-custom">
                        <div class="legend-item">
                            <span class="legend-dot"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></span>
                            <span class="legend-label">Selesai ({{ $completedCourses }})</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot"
                                style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);"></span>
                            <span class="legend-label">Sedang Berjalan ({{ $totalCourses - $completedCourses }})</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <h5 class="mb-1 fw-bold">
                                <i class="bi bi-speedometer2 me-2 text-success"></i>
                                Tingkat Penyelesaian
                            </h5>
                            <p class="text-muted small mb-0">Persentase rata-rata progress</p>
                        </div>
                    </div>
                    <div class="chart-body">
                        <canvas id="avgProgressChart"></canvas>
                    </div>
                    <div class="chart-stats">
                        <div class="chart-stat-item">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <div>
                                <p class="mb-0 small text-muted">Selesai</p>
                                <h6 class="mb-0 fw-bold">{{ $avgProgress }}%</h6>
                            </div>
                        </div>
                        <div class="chart-stat-item">
                            <i class="bi bi-hourglass-split text-warning"></i>
                            <div>
                                <p class="mb-0 small text-muted">Tersisa</p>
                                <h6 class="mb-0 fw-bold">{{ 100 - $avgProgress }}%</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Motivational Quote --}}
        <div class="row mt-5">
            <div class="col-12">
                <div class="motivational-card">
                    <i class="bi bi-quote quote-icon"></i>
                    <h4 class="mb-2">Terus Belajar, Terus Berkembang!</h4>
                    <p class="mb-0">Setiap langkah kecil membawa Anda lebih dekat ke tujuan besar Anda.</p>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Set Current Date
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const today = new Date();
        document.getElementById('currentDate').textContent = today.toLocaleDateString('id-ID', options);

        // Modern Pie Chart untuk Status Kursus
        const ctx1 = document.getElementById('courseStatusChart').getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Selesai', 'Sedang Berjalan'],
                datasets: [{
                    data: [{{ $completedCourses }}, {{ $totalCourses - $completedCourses }}],
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(245, 87, 108, 0.8)'
                    ],
                    borderWidth: 0,
                    borderRadius: 8,
                    spacing: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '65%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} kursus (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Modern Gauge Chart untuk Rata-rata Progress
        const ctx2 = document.getElementById('avgProgressChart').getContext('2d');
        const progressValue = {{ $avgProgress }};

        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Progress', 'Tersisa'],
                datasets: [{
                    data: [progressValue, 100 - progressValue],
                    backgroundColor: [
                        'rgba(17, 153, 142, 0.8)',
                        'rgba(233, 236, 239, 0.5)'
                    ],
                    borderWidth: 0,
                    borderRadius: 8,
                    spacing: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '75%',
                rotation: -90,
                circumference: 180,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                return `${label}: ${value}%`;
                            }
                        }
                    }
                }
            },
            plugins: [{
                id: 'gaugeText',
                afterDatasetDraw(chart) {
                    const {
                        ctx,
                        chartArea: {
                            width,
                            height
                        }
                    } = chart;
                    ctx.save();

                    const centerX = width / 2;
                    const centerY = height * 0.85;

                    // Draw percentage
                    ctx.font = 'bold 2.5rem sans-serif';
                    ctx.fillStyle = '#11998e';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(progressValue + '%', centerX, centerY - 20);

                    // Draw label
                    ctx.font = '0.9rem sans-serif';
                    ctx.fillStyle = '#6c757d';
                    ctx.fillText('Penyelesaian', centerX, centerY + 15);

                    ctx.restore();
                }
            }]
        });
    </script>
@endpush
