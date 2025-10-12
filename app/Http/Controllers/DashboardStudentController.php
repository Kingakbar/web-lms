<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Certificate;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use App\Models\LessonCompletion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil semua enrollment student yang sudah aktif (status pembayaran tidak pending)
        $enrollments = Enrollment::with(['course.lessons', 'lessonCompletions', 'payments'])
            ->where('user_id', $user->id)
            ->whereHas('payments', function ($q) {
                $q->where('status', '!=', 'pending');
            })
            ->get();

        // Hitung kursus aktif & selesai
        $activeCourses = 0;
        $completedCourses = 0;

        foreach ($enrollments as $enrollment) {
            $totalLessons   = $enrollment->course?->lessons?->count() ?? 0;
            $completedCount = $enrollment->lessonCompletions
                ->where('is_completed', true)
                ->count();

            if ($totalLessons > 0 && $completedCount === $totalLessons) {
                $completedCourses++;
            } elseif ($completedCount > 0 && $completedCount < $totalLessons) {
                $activeCourses++;
            }
        }

        // ✅ Total sertifikat dari kursus aktif
        $totalCertificates = Certificate::whereHas('enrollment', function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->whereHas('payments', fn($q2) => $q2->where('status', '!=', 'pending'));
        })->count();

        // ✅ Total jam belajar (jumlah lesson yang diselesaikan)
        $learningHours = LessonCompletion::whereHas('enrollment', function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->whereHas('payments', fn($q2) => $q2->where('status', '!=', 'pending'));
        })->count();

        // Kursus yang sedang berjalan (limit 2)
        $ongoingCourses = $enrollments->filter(function ($enrollment) {
            $totalLessons   = $enrollment->course?->lessons?->count() ?? 0;
            $completedCount = $enrollment->lessonCompletions
                ->where('is_completed', true)
                ->count();

            return $totalLessons > 0 && $completedCount < $totalLessons;
        })->take(2);

        // ===================== Aktivitas Terbaru =====================
        $activities = collect();

        // ✅ Aktivitas belajar (materi)
        $lessonActivities = LessonCompletion::with('lesson.course')
            ->whereHas('enrollment', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->whereHas('payments', fn($q2) => $q2->where('status', '!=', 'pending'));
            })
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($item) => [
                'type'  => 'lesson',
                'title' => 'Menyelesaikan materi: ' . optional($item->lesson)->title,
                'time'  => $item->created_at,
            ]);

        // ✅ Aktivitas quiz
        $quizActivities = QuizAttempt::with('quiz.course')
            ->where('user_id', $user->id)
            ->whereHas('quiz.course.enrollments.payments', fn($q) => $q->where('status', '!=', 'pending'))
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($item) => [
                'type'  => 'quiz',
                'title' => 'Quiz diselesaikan: ' . optional($item->quiz)->title,
                'time'  => $item->created_at,
            ]);

        // ✅ Aktivitas sertifikat
        $certificateActivities = Certificate::with('enrollment.course')
            ->whereHas('enrollment', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->whereHas('payments', fn($q2) => $q2->where('status', '!=', 'pending'));
            })
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($item) => [
                'type'  => 'certificate',
                'title' => 'Sertifikat diperoleh: ' . optional(optional($item->enrollment)->course)->title,
                'time'  => $item->issued_at,
            ]);

        $activities = $activities
            ->merge($lessonActivities)
            ->merge($quizActivities)
            ->merge($certificateActivities)
            ->sortByDesc('time')
            ->take(5);

        // === Return ke view ===
        return view('pages.dashboard.dashboard_student', compact(
            'user',
            'activeCourses',
            'completedCourses',
            'learningHours',
            'totalCertificates',
            'ongoingCourses',
            'activities'
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
