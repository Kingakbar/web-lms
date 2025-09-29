<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with(['category', 'instructor'])->latest()->paginate(10);

        return view('pages.admin.course.course_admin_index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(403, 'Fitur ini tidak tersedia untuk admin.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(403, 'Fitur ini tidak tersedia untuk admin.');
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort(403, 'Fitur ini tidak tersedia untuk admin.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(403, 'Fitur ini tidak tersedia untuk admin.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {

        foreach ($course->quizzes as $quiz) {

            $quiz->questions()->delete();


            $quiz->attempts()->delete();


            $quiz->delete();
        }

        // Hapus relasi lain
        $course->lessons()->delete();
        $course->reviews()->delete();
        $course->enrollments()->delete();
        $course->wishlists()->delete();

        // Terakhir hapus course
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course berhasil dihapus.');
    }
}
