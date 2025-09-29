<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Technest Academy - Dashboard')</title>
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
                <li>
                    <a href="{{ route('settings.page') }}" class="{{ request()->is('settings*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
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
                <li>
                    <a href="{{ route('dashboard.instructor') }}" class="{{ request()->is('dashboard*') ? 'active' : '' }}">
                        <i class="bi bi-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('courses_instructor.index') }}"
                        class="{{ request()->is('courses_instructor*') ? 'active' : '' }}">
                        <i class="bi bi-journal"></i>
                        <span>Kursus Saya</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('lessons.index') }}" class="{{ request()->is('lessons*') ? 'active' : '' }}">
                        <i class="bi bi-upload"></i>
                        <span>Kelola Materi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('quizzes.index') }}" class="{{ request()->is('quizzes*') ? 'active' : '' }}">
                        <i class="bi bi-question-circle"></i>
                        <span>Kelola Quiz</span>
                    </a>
                </li>


                <li>
                    <a href="{{ route('instructor.enrollments.index') }}"
                        class="{{ request()->routeIs('instructor.enrollments.index') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Siswa Terdaftar</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('instructor.reviews.index') }}"
                        class="{{ request()->routeIs('instructor.reviews.index') ? 'active' : '' }}">
                        <i class="bi bi-star"></i>
                        <span>Review</span>
                    </a>
                </li>





                <li>
                    <a href="{{ route('settings.page') }}" class="{{ request()->is('settings*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
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

                <li>
                    <a href="{{ route('reports.index') }}" class="{{ request()->is('reports*') ? 'active' : '' }}">
                        <i class="bi bi-bar-chart"></i>
                        <span>Laporan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('settings.page') }}" class="{{ request()->is('settings*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>



                {{-- <li><a href="#"><i class="bi bi-gear"></i><span>Pengaturan Sistem</span></a></li> --}}
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
                        @if (Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Avatar"
                                class="rounded-circle profile-avatar">
                        @else
                            <div class="user-avatar">
                                {{ strtoupper(collect(explode(' ', Auth::user()->name))->map(fn($word) => $word[0])->take(2)->join('')) }}
                            </div>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('settings.page') }}"><i
                                    class="bi bi-gear me-2"></i>Pengaturan</a>
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
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @stack('scripts')
</body>


</html>
