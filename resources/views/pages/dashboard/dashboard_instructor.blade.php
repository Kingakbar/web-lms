@extends('layouts.dashboard_layout')
@section('content')
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-success text-white p-4 rounded-3 fade-in-up">
                <h3 class="mb-2">Selamat datang kembali, {{ Auth::user()->name }}!</h3>
                <p class="mb-0 opacity-75">Ringkasan kursus dan aktivitas pengajaran Anda hari ini.</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card fade-in-up" style="animation-delay: 0.1s">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary-gradient">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number">6</div>
                        <div class="stats-label">Kursus Dibuat</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card fade-in-up" style="animation-delay: 0.2s">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number">320</div>
                        <div class="stats-label">Total Siswa</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card fade-in-up" style="animation-delay: 0.3s">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-warning">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number">Rp 12jt</div>
                        <div class="stats-label">Pendapatan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card fade-in-up" style="animation-delay: 0.4s">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-danger">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number">+12%</div>
                        <div class="stats-label">Pertumbuhan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Overview -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0">Kursus Anda</h5>
                </div>
                <div class="card-body">
                    <div class="course-card mb-3">
                        <div class="course-image"><i class="bi bi-code-slash"></i></div>
                        <div class="course-content">
                            <h6 class="course-title">Laravel Mastery</h6>
                            <p class="course-description">Framework PHP untuk web development modern</p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">320 siswa</small>
                                <small class="fw-bold">Rp 7jt</small>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 80%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="course-card mb-3">
                        <div class="course-image"><i class="bi bi-database"></i></div>
                        <div class="course-content">
                            <h6 class="course-title">Database Design</h6>
                            <p class="course-description">Belajar konsep database & SQL dengan studi kasus</p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">150 siswa</small>
                                <small class="fw-bold">Rp 3jt</small>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 60%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-custom">Kelola Semua Kursus</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Student Activity -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0">Aktivitas Siswa Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="activity-item">
                        <div class="activity-icon bg-success"><i class="bi bi-person-check"></i></div>
                        <div>
                            <div class="fw-medium">Siswa baru mendaftar</div>
                            <small class="text-muted">Kursus ReactJS - 1 jam lalu</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-primary-gradient"><i class="bi bi-chat"></i></div>
                        <div>
                            <div class="fw-medium">Komentar baru</div>
                            <small class="text-muted">Diskusi Laravel - 3 jam lalu</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-warning"><i class="bi bi-award"></i></div>
                        <div>
                            <div class="fw-medium">Siswa menyelesaikan kursus</div>
                            <small class="text-muted">Database Design - kemarin</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-danger"><i class="bi bi-currency-dollar"></i></div>
                        <div>
                            <div class="fw-medium">Pembayaran diterima</div>
                            <small class="text-muted">Kursus Laravel Mastery - 2 hari lalu</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
