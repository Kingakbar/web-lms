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

        <!-- Success Alert -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Users Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h5 class="card-title mb-0 fw-semibold">
                    <i class="bi bi-people-fill text-primary me-2"></i>
                    Daftar Pengguna
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="userTable" class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 fw-semibold text-dark ps-4">
                                    <i class="bi bi-person me-2"></i>Nama
                                </th>
                                <th class="border-0 fw-semibold text-dark">
                                    <i class="bi bi-envelope me-2"></i>Email
                                </th>
                                <th class="border-0 fw-semibold text-dark">
                                    <i class="bi bi-shield-check me-2"></i>Role
                                </th>
                                <th class="border-0 fw-semibold text-dark text-center pe-4">
                                    <i class="bi bi-gear me-2"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-0">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary bg-gradient text-white me-3">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-muted">{{ $user->email }}</span>
                                    </td>
                                    <td class="py-3">
                                        @if ($user->roles->count() > 0)
                                            @foreach ($user->roles as $role)
                                                <span class="badge bg-primary bg-gradient me-1">{{ $role->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-light text-dark">Belum ada role</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center pe-4">
                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                            <i class="bi bi-pencil-square me-1"></i>
                                            Kelola Role
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

@push('styles')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
        }

        .card {
            border-radius: 12px;
        }

        .table> :not(caption)>*>* {
            border-bottom: 1px solid #f0f0f0;
        }

        .table tbody tr:hover {
            background-color: #f8f9ff;
        }

        .btn-outline-primary {
            border-width: 1.5px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
        }

        .alert {
            border-radius: 10px;
        }

        .badge {
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 20px;
        }

        /* DataTables Custom Styling */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin: 15px 0;
        }

        .dataTables_wrapper .dataTables_length {
            margin-left: 20px;
        }

        .dataTables_wrapper .dataTables_filter {
            margin-right: 20px;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin-left: 20px;
            margin-right: 20px;
        }

        .page-link {
            border-radius: 8px;
            border: none;
            margin: 0 2px;
            color: #6c757d;
        }

        .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            border-radius: 8px;
        }
    </style>
@endpush

@push('scripts')
    {{-- jQuery & DataTables JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

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
                    } // Disable sorting for action column
                ],
                dom: '<"d-flex justify-content-between align-items-center"lf>rtip'
            });
        });
    </script>
@endpush
