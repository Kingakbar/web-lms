@extends('layouts.dashboard_layout')
@section('title', 'Review Kursus - Instructor Dashboard')
@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <!-- Modern Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="h3 fw-bold text-dark mb-1">Review Kursus</h1>
                        <p class="text-muted mb-0">Pantau feedback dan rating dari siswa Anda</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light btn-sm d-flex align-items-center gap-2">
                            <i class="bi bi-funnel text-muted"></i>
                            <span class="d-none d-sm-inline">Filter</span>
                        </button>
                        <button class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                            <i class="bi bi-download"></i>
                            <span class="d-none d-sm-inline">Export</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clean Statistics Cards -->
        <div class="row g-3 mb-4">
            <!-- Average Rating Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body text-center text-white p-4">
                        <div class="mb-3">
                            <i class="bi bi-star-fill" style="font-size: 2rem; opacity: 0.9;"></i>
                        </div>
                        <h3 class="display-5 fw-bold mb-1">
                            {{ number_format($averageRating ?? 0, 1) }}
                        </h3>
                        <p class="mb-2 opacity-90">Rata-rata Rating</p>
                        <div class="rating-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= round($averageRating ?? 0) ? '-fill' : '' }} me-1"
                                    style="font-size: 0.9rem;"></i>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Reviews Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="card-body text-center text-white p-4">
                        <div class="mb-3">
                            <i class="bi bi-chat-text-fill" style="font-size: 2rem; opacity: 0.9;"></i>
                        </div>
                        <h3 class="display-5 fw-bold mb-1">{{ $totalReviews }}</h3>
                        <p class="mb-0 opacity-90">Total Review</p>
                    </div>
                </div>
            </div>

            <!-- Rating Distribution Card -->
            <div class="col-lg-4">
                <div class="card border-0 h-100 bg-white">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-3 text-dark d-flex align-items-center">
                            <i class="bi bi-bar-chart-fill me-2 text-primary"></i>
                            Distribusi Rating
                        </h6>
                        @for ($i = 5; $i >= 1; $i--)
                            @php
                                $count = $ratingDistribution[$i] ?? 0;
                                $percentage = $totalReviews ? ($count / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3 d-flex align-items-center text-muted"
                                    style="min-width: 50px; font-size: 0.85rem;">
                                    <span class="me-1">{{ $i }}</span>
                                    <i class="bi bi-star-fill text-warning" style="font-size: 0.75rem;"></i>
                                </div>
                                <div class="progress flex-grow-1 me-3" style="height: 6px;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $percentage }}%; background: linear-gradient(90deg, #667eea, #764ba2);"
                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <span class="fw-medium text-dark"
                                    style="min-width: 25px; font-size: 0.85rem;">{{ $count }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Reviews Table -->
        <div class="card border-0 bg-white p-2">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h6 class="card-title mb-0 fw-semibold text-dark d-flex align-items-center">
                    <i class="bi bi-list-ul me-2 text-primary"></i>
                    Daftar Review Terbaru
                </h6>
            </div>

            <div class="card-body p-0">
                @if ($reviews->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 px-4 fw-semibold text-dark border-0 text-uppercase"
                                        style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                        Siswa
                                    </th>
                                    <th class="py-3 px-4 fw-semibold text-dark border-0 text-uppercase"
                                        style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                        Kursus
                                    </th>
                                    <th class="py-3 px-4 fw-semibold text-dark border-0 text-uppercase"
                                        style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                        Rating
                                    </th>
                                    <th class="py-3 px-4 fw-semibold text-dark border-0 text-uppercase"
                                        style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                        Komentar
                                    </th>
                                    <th class="py-3 px-4 fw-semibold text-dark border-0 text-uppercase"
                                        style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                        Tanggal
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $review)
                                    <tr class="border-bottom" style="border-color: #f1f3f4 !important;">
                                        <td class="py-4 px-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-3">
                                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-medium text-dark mb-1">{{ $review->user->name }}</div>
                                                    <div class="text-muted small">Siswa</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="fw-medium text-dark">{{ $review->course->title }}</div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rating-stars me-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : ' text-muted' }}"
                                                            style="font-size: 0.9rem;"></i>
                                                    @endfor
                                                </div>
                                                <span class="fw-medium text-dark">{{ $review->rating }}.0</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="text-truncate text-muted" style="max-width: 300px;"
                                                title="{{ $review->comment }}">
                                                {{ $review->comment }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="text-muted">
                                                <div class="fw-medium">{{ $review->created_at->format('d M Y') }}</div>
                                                <div class="small">{{ $review->created_at->format('H:i') }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Clean Pagination -->
                    @if ($reviews->hasPages())
                        <div class="px-4 py-3 bg-light border-top">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                @else
                    <!-- Improved Empty State -->
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-chat-square-text" style="font-size: 4rem; color: #e9ecef;"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum Ada Review</h5>
                        <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
                            Review dari siswa akan muncul di sini ketika mereka memberikan feedback tentang kursus Anda.
                        </p>
                        <button class="btn btn-primary btn-sm px-4">
                            <i class="bi bi-share me-2"></i>Bagikan Kursus
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Enhanced Custom Styles -->
    <style>
        /* Card Styles */
        .card {
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        /* Progress Bar */
        .progress {
            border-radius: 10px;
            background-color: #f1f3f4;
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 10px;
            transition: width 0.6s ease;
        }

        /* Avatar Circle */
        .avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Table Enhancements */
        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Button Styles */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary {
            width: 200px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
            transform: translateY(-1px);
        }

        .btn-light {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            color: #6c757d;
        }

        .btn-light:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        /* Rating Stars */
        .rating-stars i {
            transition: color 0.2s ease;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .table-responsive {
                border-radius: 0;
            }

            .display-5 {
                font-size: 1.75rem;
            }

            /* Stack buttons vertically on mobile */
            .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.5rem !important;
            }

            .btn-sm {
                padding: 0.5rem 1rem;
            }
        }

        @media (max-width: 576px) {

            .table th,
            .table td {
                padding: 0.75rem 0.5rem;
                font-size: 0.85rem;
            }

            .avatar-circle {
                width: 32px;
                height: 32px;
                font-size: 0.75rem;
            }

            /* Hide less important columns on mobile */
            .table th:nth-child(4),
            .table td:nth-child(4) {
                display: none;
            }
        }
    </style>
@endsection
