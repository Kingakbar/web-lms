<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Review;
use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\LessonCompletion;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardInstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instructor = Auth::user();

        // Total kursus
        $totalCourses = Course::where('user_id', $instructor->id)->count();

        // Total siswa (semua enrollment dari kursus milik instructor)
        $totalStudents = Enrollment::whereHas('course', function ($q) use ($instructor) {
            $q->where('user_id', $instructor->id);
        })->count();

        // Semua enrollments
        $totalEnrollments = Enrollment::whereHas('course', function ($q) use ($instructor) {
            $q->where('user_id', $instructor->id);
        })->count();

        // ==== FIX: Hitung Completion Rate berdasarkan LessonCompletion ====
        $instructorCourseIds = Course::where('user_id', $instructor->id)->pluck('id');
        $totalLessons = Lesson::whereIn('course_id', $instructorCourseIds)->count();

        // Total penyelesaian lesson
        $totalLessonCompletions = LessonCompletion::whereHas('enrollment.course', function ($q) use ($instructor) {
            $q->where('user_id', $instructor->id);
        })->where('is_completed', true)->count();

        // Target penyelesaian = semua lesson × semua siswa
        $totalTarget = $totalLessons * $totalStudents;

        $completionRate = $totalTarget > 0
            ? round(($totalLessonCompletions / $totalTarget) * 100)
            : 0;

        // ==== Rating Rata-rata (semua kursus instructor) ====
        $averageRating = Review::whereIn('course_id', $instructorCourseIds)->avg('rating');
        $averageRating = $averageRating ? round($averageRating, 1) : 0;

        // ==== Total Revenue (jika masih dipakai) ====
        $totalRevenue = Payment::whereHas('enrollment.course', function ($q) use ($instructor) {
            $q->where('user_id', $instructor->id);
        })->sum('amount');

        // ==== Ambil semua kursus dengan data detail ====
        $courses = Course::withCount([
            'enrollments as students_count',
            'lessons as lessons_count'
        ])
            ->with(['reviews' => function ($q) {
                $q->select('course_id', DB::raw('AVG(rating) as avg_rating'))
                    ->groupBy('course_id');
            }])
            ->where('user_id', $instructor->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($course) {
                // Hitung rating rata-rata
                $course->average_rating = $course->reviews->avg('rating') ?: 0;
                $course->reviews_count = $course->reviews->count();

                // Hitung completion rate per course
                $totalLessons = $course->lessons_count;
                $totalStudents = $course->students_count;
                $totalTarget = $totalLessons * $totalStudents;

                if ($totalTarget > 0) {
                    $completedLessons = LessonCompletion::whereHas('enrollment', function ($q) use ($course) {
                        $q->where('course_id', $course->id);
                    })->where('is_completed', true)->count();

                    $course->completion_percentage = round(($completedLessons / $totalTarget) * 100);
                } else {
                    $course->completion_percentage = 0;
                }

                return $course;
            });

        // ==== Aktivitas siswa terbaru ====
        $recentActivities = Enrollment::with(['user', 'course'])
            ->whereHas('course', function ($q) use ($instructor) {
                $q->where('user_id', $instructor->id);
            })
            ->latest()
            ->take(10)
            ->get();

        return view('pages.dashboard.dashboard_instructor', compact(
            'instructor',
            'totalCourses',
            'totalStudents',
            'completionRate',
            'averageRating',
            'totalRevenue',
            'courses',
            'recentActivities'
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
