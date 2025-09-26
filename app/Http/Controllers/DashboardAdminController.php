<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Stats
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');

        // Pertumbuhan user (bulan ini vs bulan lalu)
        $currentMonthUsers = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonthUsers = User::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $growth = $lastMonthUsers > 0
            ? round((($currentMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100, 2)
            : ($currentMonthUsers > 0 ? 100 : 0);

        // Grafik pertumbuhan user 6 bulan terakhir
        $userGrowth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $userGrowth[] = [
                'month' => $month->format('M Y'),
                'count' => User::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
            ];
        }

        // Transaksi terbaru
        $latestTransactions = Payment::with(['enrollment.course'])
            ->where('status', 'completed')
            ->latest('paid_at')
            ->take(5)
            ->get();

        // Kursus populer + revenue growth
        $popularCourses = Course::withCount('enrollments')
            ->with(['enrollments.payments' => function ($q) {
                $q->where('status', 'completed');
            }])
            ->get()
            ->map(function ($course) {
                // Revenue bulan ini
                $currentRevenue = $course->enrollments
                    ->flatMap->payments
                    ->whereBetween('paid_at', [now()->startOfMonth(), now()->endOfMonth()])
                    ->sum('amount');

                // Revenue bulan lalu
                $lastRevenue = $course->enrollments
                    ->flatMap->payments
                    ->whereBetween('paid_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
                    ->sum('amount');

                // Growth revenue
                $growth = $lastRevenue > 0
                    ? round((($currentRevenue - $lastRevenue) / $lastRevenue) * 100, 2)
                    : ($currentRevenue > 0 ? 100 : 0);

                return [
                    'title'      => $course->title,
                    'instructor' => $course->instructor->name ?? 'N/A',
                    'enrolled'   => $course->enrollments_count,
                    'revenue'    => $currentRevenue,
                    'growth'     => $growth,
                ];
            })
            ->sortByDesc('enrolled')
            ->take(5);

        return view('pages.dashboard.dashboard_admin', compact(
            'totalUsers',
            'totalCourses',
            'totalRevenue',
            'growth',
            'userGrowth',
            'latestTransactions',
            'popularCourses'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
