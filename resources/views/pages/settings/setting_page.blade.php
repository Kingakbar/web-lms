@extends('layouts.dashboard_layout')

@section('content')
    <!-- Success Alert -->
    @if (session('success'))
        <div class="success-alert" id="successAlert">
            <div class="alert-content">
                <div class="alert-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22,4 12,14.01 9,11.01"></polyline>
                    </svg>
                </div>
                <div class="alert-text">
                    <h4>Berhasil!</h4>
                    <p>{{ session('success') }}</p>
                </div>
                <button class="alert-close" onclick="closeAlert('successAlert')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="alert-progress"></div>
        </div>
    @endif

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="error-alert" id="errorAlert">
            <div class="alert-content">
                <div class="alert-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
                <div class="alert-text">
                    <h4>Terjadi Kesalahan!</h4>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                <button class="alert-close" onclick="closeAlert('errorAlert')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="alert-progress error-progress"></div>
        </div>
    @endif

    <div class="settings-container">
        <div class="settings-header">
            <h2>Pengaturan Akun</h2>
            <p>Kelola profil dan keamanan akun Anda</p>
        </div>

        <div class="settings-grid">
            <!-- Profile Card -->
            <div class="settings-card">
                <div class="card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <h3>Profil Saya</h3>
                <p>Update informasi profil Anda</p>

                <form action="{{ route('settings.updateProfile') }}" method="POST" enctype="multipart/form-data"
                    class="settings-form">
                    @csrf
                    @method('PUT')

                    <div class="avatar-section">
                        @if (Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Avatar"
                                class="current-avatar" id="avatarPreview">
                        @else
                            <div class="default-avatar" id="avatarPreviewDefault">
                                {{ strtoupper(collect(explode(' ', Auth::user()->name))->map(fn($word) => $word[0])->take(2)->join('')) }}
                            </div>
                            <img id="avatarPreview" class="current-avatar d-none" alt="Avatar">
                        @endif

                        <div class="avatar-upload">
                            <input type="file" name="profile_picture" id="profile_picture" accept="image/*"
                                onchange="previewImage(event)">
                            <label for="profile_picture" class="upload-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17,8 12,3 7,8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                                Ganti Foto
                            </label>
                            <small class="file-info">Maksimal 2MB (JPG, PNG, JPEG)</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" required>
                    </div>

                    <button type="submit" class="btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <!-- Password Card -->
            <div class="settings-card">
                <div class="card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <circle cx="12" cy="16" r="1"></circle>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
                <h3>Keamanan</h3>
                <p>Update password untuk keamanan akun</p>

                <form action="{{ route('settings.updatePassword') }}" method="POST" class="settings-form">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="current_password">Password Saat Ini</label>
                        <input type="password" name="current_password" id="current_password" required>
                    </div>

                    <div class="form-group">
                        <label for="new_password">Password Baru</label>
                        <input type="password" name="new_password" id="new_password" required>
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required>
                    </div>

                    <button type="submit" class="btn-secondary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 1v6m0 0l4-4m-4 4L8 3"></path>
                            <path d="M8 5v6a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V5"></path>
                            <path d="M3 15h18l-2 4H5l-2-4z"></path>
                        </svg>
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>



    <script>
        function closeAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.classList.add('fade-out');
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        }

        // Auto close after 4 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');

            if (successAlert) {
                setTimeout(() => {
                    closeAlert('successAlert');
                }, 4000);
            }

            if (errorAlert) {
                setTimeout(() => {
                    closeAlert('errorAlert');
                }, 6000); // kasih lebih lama biar user sempat baca error
            }
        });

        function previewImage(event) {
            const input = event.target;
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const avatarPreview = document.getElementById('avatarPreview');
                    const defaultAvatar = document.getElementById('avatarPreviewDefault');

                    avatarPreview.src = e.target.result;
                    avatarPreview.classList.remove('d-none');

                    if (defaultAvatar) {
                        defaultAvatar.style.display = 'none';
                    }
                }
                reader.readAsDataURL(file);
            }
        }
    </script>

@endsection
