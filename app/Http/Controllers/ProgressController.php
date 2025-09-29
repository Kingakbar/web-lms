<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();


        $enrollments = Enrollment::with([
            'course.lessons',
            'lessonCompletions',
            'certificate'
        ])->where('user_id', $userId)->get();


        $totalCourses = $enrollments->count();
        $completedCourses = $enrollments->filter(function ($e) {
            return $e->lessonCompletions->where('is_completed', true)->count() === $e->course->lessons->count()
                && $e->course->lessons->count() > 0;
        })->count();
        $certificates = $enrollments->whereNotNull('certificate')->count();

        // Progress rata-rata
        $avgProgress = 0;
        if ($totalCourses > 0) {
            $sum = 0;
            foreach ($enrollments as $e) {
                $totalLessons = $e->course->lessons->count();
                $completedLessons = $e->lessonCompletions->where('is_completed', true)->count();
                $sum += $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;
            }
            $avgProgress = round($sum / $totalCourses);
        }

        return view('pages.student.progress.proggress_page', compact(
            'totalCourses',
            'completedCourses',
            'certificates',
            'avgProgress'
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
