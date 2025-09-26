<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LessonController extends Controller
{
    use AuthorizesRequests;
    /**
     * Tampilkan semua lesson milik instruktur (gabungan semua course)
     */
    public function index()
    {
        $lessons = Lesson::whereHas('course', function ($q) {
            $q->where('user_id', auth()->id());
        })->with('course')->orderBy('course_id')->orderBy('order')->get();

        return view('pages.instructor.lesson.lesson_index', compact('lessons'));
    }

    /**
     * Form tambah lesson
     */
    public function create()
    {

        $courses = Course::where('user_id', auth()->id())->get();

        return view('pages.instructor.lesson.lesson_create', compact('courses'));
    }

    /**
     * Simpan lesson
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lessons.*.course_id' => 'required|exists:courses,id',
            'lessons.*.title'     => 'required|string|max:255',
            'lessons.*.content'   => 'nullable|string',
            'lessons.*.video_url' => 'nullable|url',
            'lessons.*.order'     => 'nullable|integer|min:1',
        ]);

        foreach ($validated['lessons'] as $lesson) {
            $lesson['slug'] = \Str::slug($lesson['title']) . '-' . uniqid();
            Lesson::create($lesson);
        }

        return redirect()->route('lessons.index')->with('success', 'Semua materi berhasil ditambahkan.');
    }


    /**
     * Form edit
     */
    public function edit(Lesson $lesson)
    {
        $this->authorizeLesson($lesson);

        // ambil semua course milik instruktur (untuk dropdown pindah course)
        $courses = Course::where('user_id', auth()->id())->get();

        return view('pages.instructor.lesson.lesson_edit', compact('lesson', 'courses'));
    }

    /**
     * Update satu lesson
     */
    public function update(Request $request, Lesson $lesson)
    {
        $this->authorizeLesson($lesson);

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title'     => 'required|string|max:255',
            'content'   => 'nullable|string',
            'video_url' => 'nullable|url',
            'order'     => 'nullable|integer|min:1',
        ]);

        $validated['slug'] = \Str::slug($validated['title']) . '-' . uniqid();

        $lesson->update($validated);

        return redirect()->route('lessons.index')->with('success', 'Materi berhasil diperbarui.');
    }


    /**
     * Hapus lesson
     */
    public function destroy(Lesson $lesson)
    {
        $this->authorizeLesson($lesson);

        $lesson->delete();

        return redirect()->route('lessons.index')->with('success', 'Materi berhasil dihapus.');
    }

    /**
     * Cek apakah lesson milik instruktur yang login
     */
    protected function authorizeLesson(Lesson $lesson)
    {
        if ($lesson->course->user_id !== auth()->id()) {
            abort(403, 'Tidak punya akses ke materi ini');
        }
    }
}
