<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Promo;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Enrollment;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Halaman utama laporan (overview dashboard)
     */
    public function index(Request $request)
    {
        // ========= Quick Stats (langsung query aggregate) =========
        $stats = [
            'totalRevenue'     => Payment::where('status', 'completed')->sum('amount'),
            'totalEnrollments' => Enrollment::count(),
            'totalUsers'       => User::count(),
            'totalCourses'     => Course::count(),
        ];

        // ========= Tentukan periode =========
        if ($request->filled(['start_date', 'end_date'])) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end   = Carbon::parse($request->end_date)->endOfDay();
        } else {
            $latestPaymentDate = Payment::max('paid_at');

            if ($latestPaymentDate) {
                $start = Carbon::parse($latestPaymentDate)->startOfMonth();
                $end   = Carbon::parse($latestPaymentDate)->endOfMonth();
            } else {
                $start = Carbon::now()->startOfMonth();
                $end   = Carbon::now()->endOfMonth();
            }
        }

        // ========= Ambil payments dalam rentang =========
        $payments = Payment::with(['enrollment.user'])
            ->whereBetween('paid_at', [$start, $end])
            ->get();

        // Hitung ringkasan langsung dari DB (lebih cepat dari collection)
        $financeRevenue = Payment::where('status', 'completed')
            ->whereBetween('paid_at', [$start, $end])
            ->sum('amount');

        $methodStats = Payment::select('method', DB::raw('COUNT(*) as total'))
            ->whereBetween('paid_at', [$start, $end])
            ->groupBy('method')
            ->pluck('total', 'method')
            ->toArray();

        $finance = [
            'totalRevenue' => $financeRevenue,
            'methodStats'  => $methodStats,
            'payments'     => $payments,
        ];

        // ========= Data kursus =========
        $courses = Course::withCount('enrollments')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('enrollments_count')
            ->get();

        // ========= Data user =========
        $users = User::withCount('enrollments')->get();

        // ========= Data sertifikat =========
        $certificates = Certificate::with(['enrollment.course', 'enrollment.user'])->get();

        return view('pages.admin.report.report_index', array_merge($stats, [
            'finance'      => $finance,
            'start'        => $start,
            'end'          => $end,
            'courses'      => $courses,
            'users'        => $users,
            'certificates' => $certificates,
        ]));
    }
}
