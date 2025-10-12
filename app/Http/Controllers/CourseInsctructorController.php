<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CourseInsctructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with(['category', 'instructor'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pages.instructor.course.course_insctructor_index', compact('courses'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.instructor.course.course_instructor_create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|unique:courses,slug',
            'description' => 'required|string',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:5120',
            'price'       => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');

            // Nama unik
            $filename = uniqid() . '.webp';

            // Path simpan (storage/app/public/thumbnails/)
            $path = storage_path('app/public/thumbnails/' . $filename);

            // Buat direktori kalau belum ada
            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }


            $manager = new ImageManager(new Driver());
            $processedImage = $manager->read($image->getRealPath());

            $processedImage->scale(width: 800, height: 800)
                ->toWebp(quality: 80)
                ->save($path);

            // Simpan path relatif ke disk "public" (tanpa storage/)
            $validated['thumbnail'] = 'thumbnails/' . $filename;
        }

        Course::create($validated);

        return redirect()
            ->route('courses_instructor.index')
            ->with('success', 'Kursus berhasil dibuat!');
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
    public function edit($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $categories = Category::all();

        return view('pages.instructor.course.course_instructor_edit', compact('course', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|unique:courses,slug,' . $course->id,
            'description' => 'required|string',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:5120',
            'price'       => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {

            if ($course->thumbnail && \Storage::disk('public')->exists($course->thumbnail)) {
                \Storage::disk('public')->delete($course->thumbnail);
            }

            $image = $request->file('thumbnail');
            $filename = uniqid() . '.webp';
            $path = storage_path('app/public/thumbnails/' . $filename);


            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }


            $manager = new ImageManager(new Driver());
            $processedImage = $manager->read($image->getRealPath());
            $processedImage->toWebp(quality: 80)->save($path);


            $validated['thumbnail'] = 'thumbnails/' . $filename;
        }

        $course->update($validated);

        return redirect()
            ->route('courses_instructor.index')
            ->with('success', 'Kursus berhasil diperbarui!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        // Cari course berdasarkan slug
        $course = Course::where('slug', $slug)->firstOrFail();

        // Hapus thumbnail kalau ada
        if ($course->thumbnail && \Storage::disk('public')->exists($course->thumbnail)) {
            \Storage::disk('public')->delete($course->thumbnail);
        }

        // Hapus course
        $course->delete();

        return redirect()
            ->route('courses_instructor.index')
            ->with('success', 'Kursus berhasil dihapus!');
    }
}
