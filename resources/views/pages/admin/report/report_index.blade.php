{{-- resources/views/pages/admin/report/report_index.blade.php --}}
@extends('layouts.dashboard_layout')

@section('content')
    <div class="container-fluid px-4">
        <!-- HEADER SECTION -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">Dashboard Laporan</h1>
                <p class="text-muted mb-0">Ringkasan dan analisis data sistem</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                </button>
                <button class="btn btn-primary btn-sm">
                    <i class="bi bi-download me-1"></i> Export All
                </button>
            </div>
        </div>

        <!-- STATISTICS CARDS -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                    <i class="bi bi-cash-stack text-success fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1">Total Pendapatan</div>
                                <div class="h5 mb-0 fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                    <i class="bi bi-person-check text-primary fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1">Total Pendaftaran</div>
                                <div class="h5 mb-0 fw-bold">{{ number_format($totalEnrollments) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-info bg-opacity-10 rounded-3 p-3">
                                    <i class="bi bi-people text-info fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1">Total Pengguna</div>
                                <div class="h5 mb-0 fw-bold">{{ number_format($totalUsers) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                    <i class="bi bi-book text-warning fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small mb-1">Total Kursus</div>
                                <div class="h5 mb-0 fw-bold">{{ number_format($totalCourses) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT GRID -->
        <div class="row g-4">
            <!-- LAPORAN KEUANGAN -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 rounded-2 p-2 me-3">
                                    <i class="bi bi-wallet2 text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">Laporan Keuangan</h6>
                                    <small class="text-muted">Data transaksi dan pembayaran</small>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-success dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="bi bi-download me-1"></i> Export
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="exportToExcel('financial-table', 'Laporan_Keuangan')">
                                            <i class="bi bi-file-earmark-excel me-2"></i> Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="window.print()">
                                            <i class="bi bi-printer me-2"></i> Print
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Financial Summary -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="bg-light rounded-3 p-3">
                                    <div class="text-muted small mb-1">Total Pendapatan</div>
                                    <div class="h5 mb-0 text-success fw-bold">
                                        Rp {{ number_format($finance['totalRevenue'], 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light rounded-3 p-3">
                                    <div class="text-muted small mb-1">Metode Pembayaran Populer</div>
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        @foreach ($finance['methodStats'] as $method => $count)
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                {{ $method }}: {{ $count }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Financial Table -->
                        <div class="table-responsive">
                            <table id="financial-table" class="table table-striped table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 fw-semibold">Tanggal</th>
                                        <th class="border-0 fw-semibold">Pengguna</th>
                                        <th class="border-0 fw-semibold">Metode</th>
                                        <th class="border-0 fw-semibold">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($finance['payments'] as $pay)
                                        <tr>
                                            <td>
                                                <span class="text-muted small">
                                                    {{ \Carbon\Carbon::parse($pay->paid_at)->format('d M Y, H:i') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2"
                                                        style="width:40px; height:40px;">
                                                        <i class="bi bi-person text-primary"></i>
                                                    </div>
                                                    <span>{{ $pay->enrollment->user->name ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $pay->method }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold text-success">
                                                    Rp {{ number_format($pay->amount, 0, ',', '.') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="bi bi-inbox display-4 d-block mb-3 opacity-50"></i>
                                                    <p class="mb-0">Belum ada data pembayaran</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LAPORAN KURSUS & USER -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                <i class="bi bi-book-half text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Performa Kursus</h6>
                                <small class="text-muted">Rating dan pendaftaran terbaik</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th class="border-0 fw-semibold small text-muted">KURSUS</th>
                                        <th class="border-0 fw-semibold small text-muted text-center">SISWA</th>
                                        <th class="border-0 fw-semibold small text-muted text-center">RATING</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($courses->take(5) as $course)
                                        <tr>
                                            <td>
                                                <div class="fw-medium">{{ Str::limit($course->title, 25) }}</div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                                    {{ $course->enrollments_count }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if ($course->reviews_avg_rating)
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-star-fill text-warning small me-1"></i>
                                                        <span
                                                            class="small fw-medium">{{ number_format($course->reviews_avg_rating, 1) }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted">
                                                <i class="bi bi-book opacity-50 mb-2 d-block"></i>
                                                Belum ada data kursus
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LAPORAN USER AKTIF -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 rounded-2 p-2 me-3">
                                <i class="bi bi-person-lines-fill text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Pengguna Aktif</h6>
                                <small class="text-muted">Pengguna dengan pendaftaran terbanyak</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @forelse ($users->take(5) as $user)
                            <div class="d-flex align-items-center p-3 mb-3 bg-light bg-opacity-50 rounded-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-info bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 48px; height: 48px;">
                                        <i class="bi bi-person text-info fs-5"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3 min-w-0">
                                    <div class="fw-semibold text-truncate">{{ $user->name }}</div>
                                    <div class="text-muted small text-truncate">{{ $user->email }}</div>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge bg-info text-white px-3 py-2">
                                        {{ $user->enrollments_count }} kursus
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <div class="text-muted">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                        style="width: 80px; height: 80px;">
                                        <i class="bi bi-people display-6 opacity-50"></i>
                                    </div>
                                    <p class="mb-0">Belum ada data pengguna</p>
                                    <small class="text-muted">Data akan muncul setelah ada pengguna yang mendaftar</small>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- LAPORAN SERTIFIKAT -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 rounded-2 p-2 me-3">
                                <i class="bi bi-award text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Sertifikat Terbaru</h6>
                                <small class="text-muted">Penyelesaian kursus dan pencapaian</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($certificates->count() > 0)
                            <div class="row g-3">
                                @foreach ($certificates->take(6) as $cert)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="border rounded-3 p-3 bg-light bg-opacity-50">
                                            <div class="d-flex align-items-start">
                                                <div class="bg-warning bg-opacity-10 rounded-2 p-2 me-3">
                                                    <i class="bi bi-award text-warning"></i>
                                                </div>
                                                <div class="flex-grow-1 min-w-0">
                                                    <div class="fw-medium text-truncate">
                                                        {{ $cert->enrollment->user->name ?? 'N/A' }}
                                                    </div>
                                                    <div class="text-muted small text-truncate mb-1">
                                                        {{ $cert->enrollment->course->title ?? 'N/A' }}
                                                    </div>
                                                    <div class="text-muted small">
                                                        <i class="bi bi-calendar3 me-1"></i>
                                                        {{ $cert->created_at->format('d M Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-award display-4 d-block mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada sertifikat yang diterbitkan</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        .card-hover {
            transition: all 0.2s ease-in-out;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .table th {
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .bg-opacity-10 {
            --bs-bg-opacity: 0.1;
        }
    </style>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#financial-table').DataTable({
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                    },
                    pageLength: 10,
                    order: [
                        [0, "desc"]
                    ]
                });
            });
        </script>
    @endpush


    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        function exportToExcel(tableId, filename) {

            const table = document.getElementById(tableId);
            if (!table) {
                alert('Tabel tidak ditemukan!');
                return;
            }

            const wb = XLSX.utils.table_to_book(table, {
                sheet: "Laporan"
            });


            const now = new Date();
            const timestamp = now.getFullYear() +
                String(now.getMonth() + 1).padStart(2, '0') +
                String(now.getDate()).padStart(2, '0') + '_' +
                String(now.getHours()).padStart(2, '0') +
                String(now.getMinutes()).padStart(2, '0');

            const finalFilename = filename + '_' + timestamp + '.xlsx';


            XLSX.writeFile(wb, finalFilename);
        }
    </script>
@endsection
