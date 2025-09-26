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
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Halaman utama laporan (overview dashboard)
     */
    public function index(Request $request)
    {
        // Ringkasan cepat
        $totalRevenue    = Payment::where('status', 'paid')->sum('amount');
        $totalEnrollments = Enrollment::count();
        $totalUsers      = User::count();
        $totalCourses    = Course::count();

        // Periode keuangan (jika ada filter dari request)
        $start = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $end   = $request->end_date   ? Carbon::parse($request->end_date)->endOfDay()     : Carbon::now()->endOfMonth();

        // Ambil payments dalam rentang dan eager load enrollment->user
        $payments = Payment::with('enrollment.user')
            ->whereBetween('paid_at', [$start, $end])
            ->get();

        // Hitung ringkasan keuangan dari collection payments
        $financeRevenue = $payments->where('status', 'paid')->sum('amount');
        $methodStats = $payments->groupBy('method')->map->count()->toArray();

        // Bungkus ke satu variabel agar view yang memakai $finance[] tidak error
        $finance = [
            'totalRevenue' => $financeRevenue,
            'methodStats'  => $methodStats,
            'payments'     => $payments,
        ];

        // Kursus, users, sertifikat (seperti sebelumnya)
        $courses = Course::withCount('enrollments')
            ->withAvg('reviews', 'rating')
            ->orderBy('enrollments_count', 'desc')
            ->get();

        $users = User::withCount('enrollments')->get();

        $certificates = Certificate::with('enrollment.course', 'enrollment.user')->get();

        return view('pages.admin.report.report_index', compact(
            'totalRevenue',
            'totalEnrollments',
            'totalUsers',
            'totalCourses',
            'finance',
            'start',
            'end',
            'courses',
            'users',
            'certificates'
        ));
    }
}
