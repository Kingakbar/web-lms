@extends('layouts.dashboard_layout')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Kelola Promo</h2>
                <p class="text-muted mb-0">Kelola daftar promo yang tersedia di sistem</p>
            </div>
            <div>
                <a href="{{ route('promos.create') }}" class="btn-gradient btn-gradient-primary">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Promo
                </a>
            </div>
        </div>

        <!-- Promo Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-4 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-semibold text-dark">
                    <i class="bi bi-gift-fill text-primary me-2"></i>
                    Daftar Promo
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="promoTable" class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 fw-600 text-dark ps-4 py-3">
                                    <i class="bi bi-gift me-2 text-primary"></i>Judul
                                </th>
                                <th class="border-0 fw-600 text-dark py-3">
                                    <i class="bi bi-upc me-2 text-primary"></i>Kode
                                </th>
                                <th class="border-0 fw-600 text-dark py-3">
                                    <i class="bi bi-percent me-2 text-primary"></i>Diskon (%)
                                </th>
                                <th class="border-0 fw-600 text-dark py-3">
                                    <i class="bi bi-cash-coin me-2 text-primary"></i>Potongan (Rp)
                                </th>
                                <th class="border-0 fw-600 text-dark py-3">
                                    <i class="bi bi-calendar-event me-2 text-primary"></i>Periode
                                </th>
                                <th class="border-0 fw-600 text-dark text-center pe-4 py-3">
                                    <i class="bi bi-gear me-2 text-primary"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($promos as $promo)
                                <tr class="border-bottom border-light">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-gradient-primary text-white me-3">
                                                {{ strtoupper(substr($promo->title, 0, 1)) }}
                                            </div>
                                            <div class="text-truncate" style="max-width: 160px;">
                                                <span class="fw-600 text-dark">{{ $promo->title }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-muted">{{ $promo->code }}</span>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-muted">
                                            {{ $promo->discount_percentage ? intval($promo->discount_percentage) . '%' : '-' }}
                                        </span>
                                    </td>

                                    <td class="py-4">
                                        <span class="text-muted">
                                            {{ $promo->discount_amount ? 'Rp ' . number_format($promo->discount_amount, 0, ',', '.') : '-' }}
                                        </span>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-muted">
                                            {{ \Carbon\Carbon::parse($promo->start_date)->format('d M Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse($promo->end_date)->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-center pe-4">
                                        <a href="{{ route('promos.edit', $promo->slug) }}"
                                            class="btn btn-primary-soft btn-sm rounded-pill px-3 py-2 me-1">
                                            <i class="bi bi-pencil-square me-1"></i>
                                            <span class="d-none d-sm-inline">Edit</span>
                                        </a>

                                        <form action="{{ route('promos.destroy', $promo->slug) }}" method="POST"
                                            class="d-inline-block delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-danger-soft btn-sm rounded-pill px-3 py-2 btn-delete">
                                                <i class="bi bi-trash me-1"></i>
                                                <span class="d-none d-sm-inline">Hapus</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
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
            $('#promoTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                },
                pageLength: 10,
                ordering: true,
                responsive: true,
                columnDefs: [{
                    orderable: false,
                    targets: 5
                }],
                dom: '<"d-flex justify-content-between align-items-center"lf>rtip'
            });

            // SweetAlert konfirmasi hapus
            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: "Promo ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
        });
    </script>
@endpush
