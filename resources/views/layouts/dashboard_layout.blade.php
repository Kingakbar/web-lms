<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technest Academy - Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="d-flex align-items-center">

                <img src="{{ asset('assets/img/logo.png') }}" alt="" srcset="" width="50">

                <h4>Technest Academy</h4>
            </div>
        </div>
        <ul class="sidebar-menu">
            {{-- ================= STUDENT ================= --}}
            @role('student')
                <li><a href=""><i class="bi bi-house"></i><span>Dashboard</span></a></li>
                <li><a href=""><i class="bi bi-book"></i><span>Kursus Saya</span></a></li>
                <li><a href="#"><i class="bi bi-calendar"></i><span>Jadwal</span></a></li>
                <li><a href="#"><i class="bi bi-chat-dots"></i><span>Diskusi</span></a></li>
                <li><a href="#"><i class="bi bi-award"></i><span>Sertifikat</span></a></li>
                <li><a href="#"><i class="bi bi-graph-up-arrow"></i><span>Progres</span></a></li>
                <li><a href="#"><i class="bi bi-gear"></i><span>Pengaturan</span></a></li>
                <li>
                    <a href="#" onclick="confirmLogout(event)">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endrole

            {{-- ================= INSTRUCTOR ================= --}}
            @role('instructor')
                <li><a href=""><i class="bi bi-house"></i><span>Dashboard</span></a></li>
                <li><a href=""><i class="bi bi-book"></i><span>Kursus Saya</span></a></li>
                <li><a href="#"><i class="bi bi-upload"></i><span>Kelola Materi</span></a></li>
                <li><a href="#"><i class="bi bi-people"></i><span>Siswa Terdaftar</span></a></li>
                <li><a href="#"><i class="bi bi-star"></i><span>Review</span></a></li>
                <li><a href="#"><i class="bi bi-cash-coin"></i><span>Pendapatan</span></a></li>
                <li><a href="#"><i class="bi bi-gear"></i><span>Pengaturan</span></a></li>
                <li>
                    <a href="#" onclick="confirmLogout(event)">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endrole

            {{-- ================= ADMIN ================= --}}
            @role('admin')
                <li>
                    <a href="{{ route('dashboard.admin') }}" class="{{ request()->is('dashboard*') ? 'active' : '' }}">
                        <i class="bi bi-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('users.index') }}" class="{{ request()->is('users*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Kelola User</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('categories.index') }}" class="{{ request()->is('categories*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i>
                        <span>Kategori</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('courses.index') }}" class="{{ request()->is('courses*') ? 'active' : '' }}">
                        <i class="bi bi-journal"></i>
                        <span>Semua Kursus</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('transactions.index') }}"
                        class="{{ request()->is('transactions*') ? 'active' : '' }}">
                        <i class="bi bi-wallet2"></i>
                        <span>Transaksi</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('promos.index') }}" class="{{ request()->is('promos*') ? 'active' : '' }}">
                        <i class="bi bi-ticket"></i>
                        <span>Promo</span>
                    </a>
                </li>


                <li><a href="#"><i class="bi bi-bar-chart"></i><span>Laporan</span></a></li>
                <li><a href="#"><i class="bi bi-gear"></i><span>Pengaturan Sistem</span></a></li>
                <li>
                    <a href="#" onclick="confirmLogout(event)">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endrole
        </ul>



    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <button class="btn btn-link mobile-toggle d-none me-3" onclick="toggleSidebar()">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h2 class="header-title">Dashboard</h2>
            </div>

            <div class="user-menu ms-auto">
                <div class="dropdown">
                    <button class="btn btn-link p-0" data-bs-toggle="dropdown">
                        <div class="user-avatar">JD</div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Pengaturan</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="confirmLogout(event)">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>

                    </ul>
                </div>
            </div>
        </header>


        <!-- Dashboard Content -->
        <main class="p-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        function logout() {
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                alert('Logout berhasil! Anda akan diarahkan ke halaman login.');

            }
        }


        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-toggle');

            if (window.innerWidth <= 768 &&
                !sidebar.contains(event.target) &&
                !toggle.contains(event.target) &&
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
            }
        });

        // Add loading animation to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.stats-card, .course-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = (index * 0.1) + 's';
                card.classList.add('fade-in-up');
            });
        });

        function confirmLogout(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Yakin mau keluar?',
                text: "Sesi Anda akan diakhiri.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>

    @stack('scripts')
</body>


</html>
