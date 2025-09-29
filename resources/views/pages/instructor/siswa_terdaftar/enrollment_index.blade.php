@extends('layouts.dashboard_layout')
@section('title', 'Siswa Terdaftar - Instructor Dashboard')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark mb-1 fs-3">Siswa Terdaftar</h2>
                <p class="text-muted mb-0 fs-6">Kelola dan pantau siswa yang terdaftar di kursus Anda</p>
            </div>
        </div>

        <!-- Statistik Section - Simplified -->
        <div class="row mb-5 mt-2">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center me-3"
                                style="width: 56px; height: 56px;">
                                <i class="bi bi-journal-bookmark text-white fs-4"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1 fw-normal">Total Kursus</h6>
                                <h3 class="fw-bold mb-0 text-dark">{{ $totalCourses }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-gradient-success d-flex align-items-center justify-content-center me-3"
                                style="width: 56px; height: 56px;">
                                <i class="bi bi-people text-white fs-4"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1 fw-normal">Total Siswa</h6>
                                <h3 class="fw-bold mb-0 text-dark">{{ $totalStudents }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-gradient-warning d-flex align-items-center justify-content-center me-3"
                                style="width: 56px; height: 56px;">
                                <i class="bi bi-star text-white fs-4"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1 fw-normal">Rata-rata Rating</h6>
                                <h3 class="fw-bold mb-0 text-dark">{{ $averageRating }}<span
                                        class="fs-6 text-muted">/5</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1 fw-semibold text-dark fs-5">
                            <i class="bi bi-people-fill text-primary me-2"></i>
                            Daftar Siswa
                        </h5>
                        <p class="text-muted mb-0 small">{{ $enrollments->count() }} siswa terdaftar</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="enrollmentTable" class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 fw-semibold text-dark ps-4 py-3">Siswa</th>
                                <th class="border-0 fw-semibold text-dark py-3">Kursus</th>
                                <th class="border-0 fw-semibold text-dark py-3">Tanggal Bergabung</th>
                                <th class="border-0 fw-semibold text-dark py-3">Status</th>
                                <th class="border-0 fw-semibold text-dark py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($enrollments as $enrollment)
                                <tr class="border-bottom border-light">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center text-white me-3 fw-semibold"
                                                style="width: 40px; height: 40px; font-size: 14px;">
                                                {{ strtoupper(substr($enrollment->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $enrollment->user->name }}</div>
                                                <div class="text-muted small">{{ $enrollment->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="fw-semibold text-dark">{{ $enrollment->course->title }}</div>
                                        <div class="text-muted small">
                                            @if ($enrollment->course->category)
                                                @if (is_string($enrollment->course->category))
                                                    {{ $enrollment->course->category }}
                                                @elseif(is_object($enrollment->course->category) && isset($enrollment->course->category->name))
                                                    {{ $enrollment->course->category->name }}
                                                @elseif(is_array($enrollment->course->category) && isset($enrollment->course->category['name']))
                                                    {{ $enrollment->course->category['name'] }}
                                                @else
                                                    Kategori tidak tersedia
                                                @endif
                                            @else
                                                Kategori tidak tersedia
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-muted">
                                            {{ $enrollment->enrolled_at ?? $enrollment->created_at->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td class="py-4">
                                        @php $paymentStatus = $enrollment->payment_status ?? 'pending'; @endphp

                                        @switch($paymentStatus)
                                            @case('completed')
                                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                                    <i class="bi bi-check-circle-fill me-1"></i>Aktif
                                                </span>
                                            @break

                                            @case('pending')
                                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">
                                                    <i class="bi bi-clock-fill me-1"></i>Pending
                                                </span>
                                            @break

                                            @case('failed')
                                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                                                    <i class="bi bi-x-circle-fill me-1"></i>Gagal
                                                </span>
                                            @break

                                            @default
                                                <span
                                                    class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">
                                                    <i class="bi bi-question-circle-fill me-1"></i>Unknown
                                                </span>
                                        @endswitch
                                    </td>


                                    <td class="py-4 text-center">
                                        <button class="btn btn-outline-primary btn-sm px-3 py-2 rounded-pill"
                                            data-bs-toggle="modal" data-bs-target="#detailModal{{ $enrollment->id }}">
                                            <i class="bi bi-eye me-1"></i> Detail
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modern Detail Modal -->
                                <div class="modal fade" id="detailModal{{ $enrollment->id }}" tabindex="-1"
                                    aria-labelledby="detailModalLabel{{ $enrollment->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0 shadow-lg rounded-4">
                                            <!-- Modal Header -->
                                            <div class="modal-header border-0 pb-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center text-white me-3 fw-semibold"
                                                        style="width: 50px; height: 50px;">
                                                        {{ strtoupper(substr($enrollment->user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <h5 class="modal-title fw-bold text-dark mb-0">
                                                            {{ $enrollment->user->name }}</h5>
                                                        <p class="text-muted mb-0 small">Detail informasi siswa</p>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <!-- Modal Body -->
                                            <div class="modal-body pt-4">
                                                <div class="row g-4">
                                                    <!-- Student Info Card -->
                                                    <div class="col-12">
                                                        <div class="card border-0 bg-light bg-opacity-50 rounded-3">
                                                            <div class="card-body p-4">
                                                                <h6 class="fw-semibold text-dark mb-3">
                                                                    <i class="bi bi-person-circle text-primary me-2"></i>
                                                                    Informasi Siswa
                                                                </h6>
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="text-muted small fw-semibold">Nama
                                                                            Lengkap</label>
                                                                        <div class="fw-semibold text-dark">
                                                                            {{ $enrollment->user->name }}</div>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label
                                                                            class="text-muted small fw-semibold">Email</label>
                                                                        <div class="text-dark">
                                                                            {{ $enrollment->user->email }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Course Info Card -->
                                                    <div class="col-12">
                                                        <div class="card border-0 bg-light bg-opacity-50 rounded-3">
                                                            <div class="card-body p-4">
                                                                <h6 class="fw-semibold text-dark mb-3">
                                                                    <i class="bi bi-book text-primary me-2"></i>
                                                                    Informasi Kursus
                                                                </h6>
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="text-muted small fw-semibold">Nama
                                                                            Kursus</label>
                                                                        <div class="fw-semibold text-dark">
                                                                            {{ $enrollment->course->title }}</div>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="text-muted small fw-semibold">Tanggal
                                                                            Bergabung</label>
                                                                        <div class="text-dark">
                                                                            {{ $enrollment->enrolled_at ?? $enrollment->created_at->format('d M Y, H:i') }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Payment Status Card -->
                                                    <div class="col-12">
                                                        <div class="card border-0 bg-light bg-opacity-50 rounded-3">
                                                            <div class="card-body p-4">
                                                                <h6 class="fw-semibold text-dark mb-3">
                                                                    <i class="bi bi-credit-card text-primary me-2"></i>
                                                                    Status Pembayaran
                                                                </h6>
                                                                <div class="d-flex align-items-center">
                                                                    @php $paymentStatus = $enrollment->payment_status ?? 'pending'; @endphp

                                                                    @switch($paymentStatus)
                                                                        @case('completed')
                                                                            <div
                                                                                class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill me-3">
                                                                                <i
                                                                                    class="bi bi-check-circle-fill me-1"></i>Pembayaran
                                                                                Berhasil
                                                                            </div>
                                                                            <small class="text-muted">Siswa telah menyelesaikan
                                                                                pembayaran</small>
                                                                        @break

                                                                        @case('pending')
                                                                            <div
                                                                                class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill me-3">
                                                                                <i class="bi bi-clock-fill me-1"></i>Menunggu
                                                                                Pembayaran
                                                                            </div>
                                                                            <small class="text-muted">Pembayaran sedang
                                                                                diproses</small>
                                                                        @break

                                                                        @case('failed')
                                                                            <div
                                                                                class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill me-3">
                                                                                <i class="bi bi-x-circle-fill me-1"></i>Pembayaran
                                                                                Gagal
                                                                            </div>
                                                                            <small class="text-muted">Siswa gagal melakukan
                                                                                pembayaran</small>
                                                                        @break

                                                                        @default
                                                                            <div
                                                                                class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill me-3">
                                                                                <i
                                                                                    class="bi bi-question-circle-fill me-1"></i>Status
                                                                                Tidak Diketahui
                                                                            </div>
                                                                            <small class="text-muted">Tidak ada informasi
                                                                                pembayaran</small>
                                                                    @endswitch
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <!-- Modal Footer -->
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-primary px-4 py-2 rounded-pill"
                                                    data-bs-dismiss="modal">Tutup</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal -->
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#enrollmentTable').DataTable({
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
                        emptyTable: "Belum ada siswa yang terdaftar.",
                        search: "Cari siswa:",
                        lengthMenu: "Tampilkan _MENU_ siswa per halaman",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ siswa",
                        infoEmpty: "Tidak ada siswa",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        }
                    },
                    pageLength: 10,
                    ordering: true,
                    responsive: true,
                    dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rtip',
                    columnDefs: [{
                        orderable: false,
                        targets: [4]
                    }],
                    order: [
                        [2, 'desc']
                    ]
                });
            });

            document.addEventListener("DOMContentLoaded", function() {
                const tbody = document.getElementById("enrollmentTableBody");


                if (tbody.children.length === 0) {
                    tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center text-muted py-5">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi bi-people text-muted fs-1 mb-3"></i>
                        <h6 class="text-muted">Belum Ada Siswa</h6>
                        <p class="text-muted small mb-0">
                            Belum ada siswa yang mendaftar ke kursus Anda
                        </p>
                    </div>
                </td>
            </tr>
        `;
                }
            });
        </script>
    @endpush
