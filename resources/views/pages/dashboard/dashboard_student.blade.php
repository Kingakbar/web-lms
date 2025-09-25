@extends('layouts.dashboard_layout')
@section('content')
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-primary-gradient text-white p-4 rounded-3 fade-in-up">
                <h3 class="mb-2">Selamat datang kembali, John Doe!</h3>
                <p class="mb-0 opacity-75">Anda memiliki 3 tugas yang perlu diselesaikan hari ini</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card fade-in-up" style="animation-delay: 0.1s">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary-gradient">
                        <i class="bi bi-book"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number">12</div>
                        <div class="stats-label">Kursus Aktif</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card fade-in-up" style="animation-delay: 0.2s">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number">8</div>
                        <div class="stats-label">Diselesaikan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card fade-in-up" style="animation-delay: 0.3s">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-warning">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number">24</div>
                        <div class="stats-label">Jam Belajar</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card fade-in-up" style="animation-delay: 0.4s">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-danger">
                        <i class="bi bi-award"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number">5</div>
                        <div class="stats-label">Sertifikat</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Progress -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0">Kursus Berlangsung</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="course-card">
                                <div class="course-image">
                                    <i class="bi bi-code-slash"></i>
                                </div>
                                <div class="course-content">
                                    <h6 class="course-title">Web Development</h6>
                                    <p class="course-description">Belajar HTML, CSS, dan JavaScript dari dasar
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="text-muted">Progres</small>
                                        <small class="fw-bold">75%</small>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="course-card">
                                <div class="course-image">
                                    <i class="bi bi-database"></i>
                                </div>
                                <div class="course-content">
                                    <h6 class="course-title">Database Design</h6>
                                    <p class="course-description">Menguasai konsep database dan SQL</p>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="text-muted">Progres</small>
                                        <small class="fw-bold">45%</small>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 45%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-custom">Lihat Semua Kursus</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Feed -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0">Aktivitas Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="activity-item">
                        <div class="activity-icon bg-success">
                            <i class="bi bi-check"></i>
                        </div>
                        <div>
                            <div class="fw-medium">Quiz diselesaikan</div>
                            <small class="text-muted">JavaScript Fundamentals - 2 jam lalu</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-primary-gradient">
                            <i class="bi bi-play"></i>
                        </div>
                        <div>
                            <div class="fw-medium">Video ditonton</div>
                            <small class="text-muted">Introduction to React - 5 jam lalu</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-warning">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div>
                            <div class="fw-medium">Deadline mendekat</div>
                            <small class="text-muted">Project Final - 1 hari lagi</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-danger">
                            <i class="bi bi-award"></i>
                        </div>
                        <div>
                            <div class="fw-medium">Sertifikat diperoleh</div>
                            <small class="text-muted">HTML & CSS Mastery - 3 hari lalu</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
