@extends('layouts.dashboard_layout')

@section('content')
    <div class="container-fluid px-4 fade-in-up">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('users.index') }}" class="btn-back">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Users
            </a>
        </div>

        <!-- Main Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <!-- User Header -->
                <div class="user-header mb-4">
                    <div class="user-avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="fw-600 mb-1">{{ $user->name }}</h4>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- Success Alert -->
                @if (session('success'))
                    <div class="alert alert-success border-0 rounded-3 mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-4">
                        <label class="form-label fw-500 mb-3">Role Pengguna</label>
                        <div class="select-wrapper">
                            <select name="role" class="form-select-custom" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="bi bi-chevron-down select-arrow"></i>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary-modern">
                            <i class="bi bi-check-lg me-2"></i>Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
