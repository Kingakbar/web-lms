<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{

    public function index()
    {
        $quizzes = Quiz::with('course')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pages.instructor.quiz.quis_index', compact('quizzes'));
    }


    public function create()
    {
        $courses = Course::where('user_id', auth()->id())->get();
        return view('pages.instructor.quiz.quis_create', compact('courses'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'course_id'     => 'required|exists:courses,id',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'passing_score' => 'required|numeric|min:0|max:100',
            'questions.*.question'       => 'nullable|string',
            'questions.*.option_a'       => 'nullable|string',
            'questions.*.option_b'       => 'nullable|string',
            'questions.*.option_c'       => 'nullable|string',
            'questions.*.option_d'       => 'nullable|string',
            'questions.*.correct_answer' => 'nullable|in:A,B,C,D',
        ]);

        $quiz = Quiz::create([
            'course_id'     => $request->course_id,
            'title'         => $request->title,
            'description'   => $request->description,
            'passing_score' => $request->passing_score,
            'user_id'       => Auth::id(),
        ]);

        if ($request->has('questions')) {
            $quiz->questions()->createMany($request->questions);
        }

        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz berhasil dibuat!');
    }


    public function edit($id)
    {
        $quiz = Quiz::with('questions')
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        $courses = Course::where('user_id', auth()->id())->get();

        return view('pages.instructor.quiz.quis_edit', compact('quiz', 'courses'));
    }

    /**
     * Update quiz + soal
     */
    public function update(Request $request, $id)
    {
        $quiz = Quiz::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'passing_score' => 'required|numeric|min:0|max:100',
            'questions.*.id'             => 'nullable|exists:quiz_questions,id',
            'questions.*.question'       => 'nullable|string',
            'questions.*.option_a'       => 'nullable|string',
            'questions.*.option_b'       => 'nullable|string',
            'questions.*.option_c'       => 'nullable|string',
            'questions.*.option_d'       => 'nullable|string',
            'questions.*.correct_answer' => 'nullable|in:A,B,C,D',
        ]);

        $quiz->update($request->only('title', 'description', 'passing_score'));

        if ($request->has('questions')) {
            foreach ($request->questions as $q) {
                if (isset($q['id'])) {
                    $quiz->questions()->where('id', $q['id'])->update($q);
                } else {
                    $quiz->questions()->create($q);
                }
            }
        }

        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $quiz = Quiz::where('user_id', Auth::id())->findOrFail($id);
        $quiz->questions()->delete();
        $quiz->delete();

        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz berhasil dihapus!');
    }
}
