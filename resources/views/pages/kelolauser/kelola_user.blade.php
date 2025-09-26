@extends('layouts.dashboard_layout')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Kelola User</h2>
                <p class="text-muted mb-0">Kelola role dan akses pengguna sistem</p>
            </div>
        </div>
        <!-- Users Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-4">
                <h5 class="card-title mb-0 fw-semibold text-dark">
                    <i class="bi bi-people-fill text-primary me-2"></i>
                    Daftar Pengguna
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="userTable" class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 fw-600 text-dark ps-4 py-3">
                                    <i class="bi bi-person me-2 text-primary"></i>Nama
                                </th>
                                <th class="border-0 fw-600 text-dark py-3">
                                    <i class="bi bi-envelope me-2 text-primary"></i>Email
                                </th>
                                <th class="border-0 fw-600 text-dark py-3">
                                    <i class="bi bi-shield-check me-2 text-primary"></i>Role
                                </th>
                                <th class="border-0 fw-600 text-dark text-center pe-4 py-3">
                                    <i class="bi bi-gear me-2 text-primary"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-bottom border-light">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-gradient-primary text-white me-3">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div class="text-truncate" style="max-width: 160px;">
                                                <span class="fw-600 text-dark">{{ $user->name }}</span>
                                            </div>

                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-muted">{{ $user->email }}</span>
                                    </td>
                                    <td class="py-4">
                                        @if ($user->roles->count() > 0)
                                            @foreach ($user->roles as $role)
                                                <span
                                                    class="badge btn-primary-soft text-primary me-1 text-white">{{ $role->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-gray-soft text-muted">Belum ada role</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-center pe-4">
                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="btn btn-primary-soft btn-sm rounded-pill px-3 py-2">
                                            <i class="bi bi-pencil-square me-1"></i>
                                            <span class="d-none d-sm-inline">Kelola Role</span>
                                        </a>
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
            $('#userTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                },
                pageLength: 10,
                ordering: true,
                responsive: true,
                columnDefs: [{
                    orderable: false,
                    targets: 3
                }],
                dom: '<"d-flex justify-content-between align-items-center"lf>rtip'
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
