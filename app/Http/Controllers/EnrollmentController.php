<?php

namespace App\Http\Controllers;


use App\Models\Course;
use App\Models\Review;
use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\LessonCompletion;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index()
    {
        $instructorId = Auth::id();

        // Ambil enrollments + eager load course (dengan jumlah lessons) + payments (ordered latest first) + user
        $enrollments = Enrollment::with([
            'user',
            'course' => function ($q) {
                $q->withCount('lessons');
            },
            'payments' => function ($q) {
                $q->orderBy('paid_at', 'desc')->orderBy('id', 'desc');
            }
        ])
            ->whereHas('course', function ($query) use ($instructorId) {
                $query->where('user_id', $instructorId);
            })
            ->latest()
            ->paginate(10);

        // Transform collection (masih aman karena kita transform collection di paginator)
        $enrollments->getCollection()->transform(function ($enrollment) {
            // Ambil payment terbaru dari relasi payments (karena kita sudah orderBy paid_at desc)
            $latestPayment = $enrollment->payments->first();

            $enrollment->payment_status = $latestPayment->status ?? 'pending'; // pending jika tidak ada payment
            $enrollment->payment_amount = $latestPayment->amount ?? null;

            // Hitung completed lessons untuk enrollment ini (relasi Enrollment->lessonCompletions harus ada)
            $enrollment->completed_lessons_count = $enrollment->lessonCompletions()
                ->where('is_completed', true)
                ->count();

            // Total lessons pada kursus (dari course->lessons_count yang sudah eager-loaded)
            $lessonsCount = $enrollment->course->lessons_count ?? 0;
            $enrollment->progress_percentage = $lessonsCount > 0
                ? round(($enrollment->completed_lessons_count / $lessonsCount) * 100, 1)
                : 0;

            return $enrollment;
        });

        // Statistik tambahan (sama seperti sebelumnya)
        $totalCourses = Course::where('user_id', $instructorId)->count();

        $totalStudents = Enrollment::whereHas('course', function ($q) use ($instructorId) {
            $q->where('user_id', $instructorId);
        })->distinct('user_id')->count('user_id');

        $totalRevenue = Payment::whereHas('enrollment.course', function ($q) use ($instructorId) {
            $q->where('user_id', $instructorId);
        })->sum('amount');

        $averageRating = Review::whereHas('course', function ($q) use ($instructorId) {
            $q->where('user_id', $instructorId);
        })->avg('rating');
        $averageRating = $averageRating ? round($averageRating, 1) : 0;

        // Average progress overall (optional)
        $totalLessonCompletions = LessonCompletion::whereHas('enrollment.course', function ($q) use ($instructorId) {
            $q->where('user_id', $instructorId);
        })->where('is_completed', true)->count();

        $totalLessons = DB::table('lessons')
            ->join('courses', 'lessons.course_id', '=', 'courses.id')
            ->where('courses.user_id', $instructorId)
            ->count();

        $averageProgress = ($totalLessons > 0 && $totalStudents > 0)
            ? round(($totalLessonCompletions / ($totalLessons * $totalStudents)) * 100, 1)
            : 0;

        // Recent students
        $recentStudents = Enrollment::with(['user', 'course'])
            ->whereHas('course', function ($q) use ($instructorId) {
                $q->where('user_id', $instructorId);
            })->latest()->take(5)->get();

        return view('pages.instructor.siswa_terdaftar.enrollment_index', compact(
            'enrollments',
            'totalCourses',
            'totalStudents',
            'totalRevenue',
            'averageRating',
            'averageProgress',
            'recentStudents'
        ));
    }
}
