@extends('layouts.dashboard_layout')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Kelola Transaksi</h2>
                <p class="text-muted mb-0">Daftar transaksi pembayaran kursus di sistem</p>
            </div>
        </div>

        <!-- Transactions Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-4 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-semibold text-dark">
                    <i class="bi bi-credit-card-fill text-primary me-2"></i>
                    Daftar Transaksi
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="transactionTable" class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 fw-600 text-dark ps-4 py-3">
                                    <i class="bi bi-person me-2 text-primary"></i>User
                                </th>
                                <th class="border-0 fw-600 text-dark py-3">
                                    <i class="bi bi-journal-text me-2 text-primary"></i>Kursus
                                </th>
                                <th class="border-0 fw-600 text-dark py-3">
                                    <i class="bi bi-cash-coin me-2 text-primary"></i>Jumlah
                                </th>
                                <th class="border-0 fw-600 text-dark py-3">
                                    <i class="bi bi-wallet2 me-2 text-primary"></i>Metode
                                </th>
                                <th class="border-0 fw-600 text-dark py-3">
                                    <i class="bi bi-flag me-2 text-primary"></i>Status
                                </th>
                                <th class="border-0 fw-600 text-dark py-3">
                                    <i class="bi bi-calendar me-2 text-primary"></i>Tanggal Bayar
                                </th>
                                <th class="border-0 fw-600 text-dark text-center pe-4 py-3">
                                    <i class="bi bi-gear me-2 text-primary"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $trx)
                                <tr class="border-bottom border-light">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-gradient-primary text-white me-3">
                                                {{ strtoupper(substr($trx->enrollment->user->name ?? '-', 0, 1)) }}
                                            </div>
                                            <div class="text-truncate" style="max-width: 160px;">
                                                <span
                                                    class="fw-600 text-dark">{{ $trx->enrollment->user->name ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-muted">{{ $trx->enrollment->course->title ?? '-' }}</span>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-dark">Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-muted">{{ ucfirst($trx->method) }}</span>
                                    </td>
                                    <td class="py-4">
                                        @if ($trx->status === 'paid')
                                            <span class="badge bg-success">Lunas</span>
                                        @elseif($trx->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Gagal</span>
                                        @endif
                                    </td>
                                    <td class="py-4">
                                        <span class="text-muted">
                                            {{ $trx->paid_at ? \Carbon\Carbon::parse($trx->paid_at)->format('d M Y') : '-' }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-center pe-4">
                                        <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST"
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
            $('#transactionTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                },
                pageLength: 10,
                ordering: true,
                responsive: true,
                columnDefs: [{
                    orderable: false,
                    targets: 6
                }],
                dom: '<"d-flex justify-content-between align-items-center"lf>rtip'
            });

            // SweetAlert konfirmasi hapus
            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: "Transaksi ini akan dihapus permanen!",
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
