@extends('layouts.dashboard_layout')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Kelola Kategori</h2>
                <p class="text-muted mb-0">Kelola daftar kategori kursus di sistem</p>
            </div>
            <div>
                <a href="{{ route('categories.create') }}" class="btn-gradient btn-gradient-primary">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Kategori
                </a>
            </div>
        </div>

        <!-- Categories Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-4 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-semibold text-dark">
                    <i class="bi bi-tags-fill text-primary me-2"></i>
                    Daftar Kategori
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="categoryTable" class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 fw-600 text-dark ps-4 py-3">
                                    <i class="bi bi-tag me-2 text-primary"></i>Nama Kategori
                                </th>
                                <th class="border-0 fw-600 text-dark py-3">
                                    <i class="bi bi-slash-circle me-2 text-primary"></i>Slug
                                </th>
                                <th class="border-0 fw-600 text-dark text-center pe-4 py-3">
                                    <i class="bi bi-gear me-2 text-primary"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr class="border-bottom border-light">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-gradient-primary text-white me-3">
                                                {{ strtoupper(substr($category->name, 0, 1)) }}
                                            </div>
                                            <div class="text-truncate" style="max-width: 160px;">
                                                <span class="fw-600 text-dark">{{ $category->name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-muted">{{ $category->slug }}</span>
                                    </td>
                                    <td class="py-4 text-center pe-4">
                                        <a href="{{ route('categories.edit', $category->slug) }}"
                                            class="btn btn-primary-soft btn-sm rounded-pill px-3 py-2 me-1">
                                            <i class="bi bi-pencil-square me-1"></i>
                                            <span class="d-none d-sm-inline">Edit</span>
                                        </a>

                                        <form action="{{ route('categories.destroy', $category->slug) }}" method="POST"
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
            $('#categoryTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                },
                pageLength: 10,
                ordering: true,
                responsive: true,
                columnDefs: [{
                    orderable: false,
                    targets: 2
                }],
                dom: '<"d-flex justify-content-between align-items-center"lf>rtip'
            });

            // SweetAlert untuk konfirmasi hapus
            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: "Kategori ini akan dihapus permanen!",
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
