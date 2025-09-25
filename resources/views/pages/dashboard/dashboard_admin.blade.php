@extends('layouts.dashboard_layout')
@section('content')
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-dark text-white p-4 rounded-3 fade-in-up">
                <h3 class="mb-2">Selamat datang, Admin {{ Auth::user()->name }}!</h3>
                <p class="mb-0 opacity-75">Ini ringkasan aktivitas dan statistik sistem LMS.</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card fade-in-up" style="animation-delay: 0.1s">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary-gradient">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number">1,245</div>
                        <div class="stats-label">Total Pengguna</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card fade-in-up" style="animation-delay: 0.2s">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number">320</div>
                        <div class="stats-label">Total Kursus</div>
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
                        <div class="stats-number">Rp 75jt</div>
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
                        <div class="stats-number">+18%</div>
                        <div class="stats-label">Pertumbuhan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Recent Activity -->
    <div class="row">
        <!-- User Growth Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0">Grafik Pertumbuhan Pengguna</h5>
                </div>
                <div class="card-body">
                    <canvas id="userGrowthChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- Latest Transactions -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0">Transaksi Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="activity-item">
                        <div class="activity-icon bg-success"><i class="bi bi-cash"></i></div>
                        <div>
                            <div class="fw-medium">Rp 500.000</div>
                            <small class="text-muted">Pembayaran kursus ReactJS - 1 jam lalu</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-primary-gradient"><i class="bi bi-cash"></i></div>
                        <div>
                            <div class="fw-medium">Rp 250.000</div>
                            <small class="text-muted">Pembayaran kursus Laravel - 3 jam lalu</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-warning"><i class="bi bi-cash"></i></div>
                        <div>
                            <div class="fw-medium">Rp 1.000.000</div>
                            <small class="text-muted">Pembayaran kursus Data Science - kemarin</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kursus Populer -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0">Kursus Populer</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kursus</th>
                                <th>Instruktur</th>
                                <th>Enrolled</th>
                                <th>Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Laravel Mastery</td>
                                <td>Jane Smith</td>
                                <td>250 siswa</td>
                                <td>Rp 12jt</td>
                            </tr>
                            <tr>
                                <td>React Advanced</td>
                                <td>John Doe</td>
                                <td>180 siswa</td>
                                <td>Rp 9jt</td>
                            </tr>
                            <tr>
                                <td>Python Data Science</td>
                                <td>Michael Lee</td>
                                <td>300 siswa</td>
                                <td>Rp 15jt</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
