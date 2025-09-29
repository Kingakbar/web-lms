<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Enrollment;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use App\Models\LessonCompletion;
use App\Http\Controllers\Controller;

class CourseStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments = Enrollment::with('course.category', 'course.instructor', 'course.lessons', 'course.quizzes', 'course.reviews', 'lessonCompletions')
            ->where('user_id', auth()->id())
            ->paginate(6);

        return view('pages.student.kursus.course_student', compact('enrollments'));
    }



    public function lesson($courseSlug, $lessonSlug)
    {
        $course = Course::where('slug', $courseSlug)->with('lessons')->firstOrFail();
        $lesson = $course->lessons()->where('slug', $lessonSlug)->firstOrFail();

        $enrollment = Enrollment::where('course_id', $course->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Hanya ambil data completion
        $completion = LessonCompletion::where('enrollment_id', $enrollment->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        return view('pages.student.kursus.belajar_page', compact(
            'course',
            'lesson',
            'enrollment',
            'completion'
        ));
    }


    public function quiz($courseSlug, $quizId)
    {
        $course = Course::where('slug', $courseSlug)->with('lessons')->firstOrFail();
        $quiz = Quiz::where('course_id', $course->id)
            ->with('questions')
            ->findOrFail($quizId);

        $enrollment = Enrollment::where('course_id', $course->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $quizAttempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', auth()->id())
            ->latest()
            ->first();

        return view('pages.student.kursus.belajar_page', compact(
            'course',
            'quiz',
            'enrollment',
            'quizAttempt'
        ));
    }

    public function submitQuiz(Request $request, $courseSlug, $quizId)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $quiz = Quiz::with('questions')->findOrFail($quizId);

        $answers = $request->input('answers', []);
        $score = 0;
        $total = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $correctAnswer = $question->correct_answer;

            // Bandingkan case-insensitive
            if ($userAnswer && strtolower($userAnswer) === strtolower($correctAnswer)) {
                $score++;
            }
        }

        $finalScore = $total > 0 ? round(($score / $total) * 100) : 0;
        $passed = $finalScore >= $quiz->passing_score;

        QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => auth()->id(),
            'score' => $finalScore,
            'passed' => $passed,
        ]);

        return redirect()->route('learn.quiz', [$course->slug, $quiz->id])
            ->with('success', "Quiz selesai. Skor kamu: $finalScore ($score dari $total jawaban benar)");
    }



    public function completeLesson(Course $course, Lesson $lesson)
    {
        $enrollment = Enrollment::where('course_id', $course->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        LessonCompletion::updateOrCreate(
            [
                'enrollment_id' => $enrollment->id,
                'lesson_id'     => $lesson->id,
            ],
            [
                'is_completed'  => true,
                'completed_at'  => now(),
            ]
        );

        // cari lesson berikut
        $next = $course->lessons()
            ->where('order', '>', $lesson->order)
            ->orderBy('order')
            ->first();

        if ($next) {
            return redirect()->route('learn.lesson', [$course->slug, $next->slug])
                ->with('success', 'Lesson selesai, lanjut ke berikutnya.');
        }

        return redirect()->route('learn.lesson', [$course->slug, $lesson->slug])
            ->with('success', 'Lesson selesai.');
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
