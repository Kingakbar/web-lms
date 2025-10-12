<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ClientSideController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::withCount('courses')
            ->having('courses_count', '>', 0)
            ->get();

        $courses = Course::with(['instructor', 'category', 'reviews', 'lessons'])
            ->when($request->category, function ($query, $categorySlug) {
                $query->whereHas('category', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            })
            ->latest()
            ->take(6)
            ->get();

        // Ambil promo yang aktif
        $promos = Promo::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'courses' => $courses->map(function ($course) {
                    return [
                        'id' => $course->id,
                        'title' => $course->title,
                        'slug' => $course->slug,
                        'description' => $course->description,
                        'thumbnail' => $course->thumbnail,
                        'price' => $course->price,
                        'reviews_avg_rating' => $course->reviews->avg('rating') ?? 0,
                        'lessons_sum_duration' => $course->lessons->sum('duration') ?? 0,
                        'instructor' => [
                            'name' => $course->instructor->name ?? 'Instruktur',
                            'profile_picture' => $course->instructor->profile_picture ?? null,
                        ],
                    ];
                }),
                'promos' => $promos->map(function ($promo) {
                    return [
                        'id' => $promo->id,
                        'title' => $promo->title,
                        'slug' => $promo->slug,
                        'code' => $promo->code,
                        'discount_percentage' => $promo->discount_percentage,
                        'discount_amount' => $promo->discount_amount,
                        'start_date' => $promo->start_date,
                        'end_date' => $promo->end_date,
                    ];
                }),
            ]);
        }

        return view('pages.client.landing_page', compact('courses', 'categories', 'promos'));
    }


    public function all(Request $request)
    {
        $categories = Category::withCount('courses')
            ->having('courses_count', '>', 0)
            ->get();

        // Ambil semua promo aktif
        $promos = Promo::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        // Query dasar course
        $coursesQuery = Course::with(['instructor', 'category', 'reviews', 'lessons']);

        // 🔹 Filter berdasarkan kategori
        if ($request->filled('category')) {
            $coursesQuery->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 🔹 Filter kelas gratis / berbayar
        if ($request->filled('type')) {
            if ($request->type === 'gratis') {
                $coursesQuery->where('price', 0);
            } elseif ($request->type === 'berbayar') {
                $coursesQuery->where('price', '>', 0);
            }
        }

        // 🔹 Urutkan hasil (terbaru, terlama, populer, dll)
        switch ($request->sort) {
            case 'terlama':
                $coursesQuery->oldest();
                break;
            case 'terbaru':
                $coursesQuery->latest();
                break;
            case 'termurah':
                $coursesQuery->orderBy('price', 'asc');
                break;
            case 'termahal':
                $coursesQuery->orderBy('price', 'desc');
                break;
            case 'terpopuler':
                // contoh: berdasarkan rating rata-rata tertinggi
                $coursesQuery->withAvg('reviews', 'rating')
                    ->orderByDesc('reviews_avg_rating');
                break;
            default:
                $coursesQuery->latest();
                break;
        }

        // 🔹 Paginate hasil
        $courses = $coursesQuery->paginate(12);

        // 🔹 Jika request AJAX / JSON → kirim data JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'courses' => $courses->map(function ($course) {
                    return [
                        'id' => $course->id,
                        'title' => $course->title,
                        'slug' => $course->slug,
                        'description' => $course->description,
                        'thumbnail' => $course->thumbnail,
                        'price' => $course->price,
                        'reviews_avg_rating' => $course->reviews->avg('rating') ?? 0,
                        'lessons_sum_duration' => $course->lessons->sum('duration') ?? 0,
                        'instructor' => [
                            'name' => $course->instructor->name ?? 'Instruktur',
                            'profile_picture' => $course->instructor->profile_picture ?? null,
                        ],
                    ];
                }),
                'promos' => $promos->map(function ($promo) {
                    return [
                        'id' => $promo->id,
                        'title' => $promo->title,
                        'slug' => $promo->slug,
                        'code' => $promo->code,
                        'discount_percentage' => $promo->discount_percentage,
                        'discount_amount' => $promo->discount_amount,
                        'start_date' => $promo->start_date,
                        'end_date' => $promo->end_date,
                    ];
                }),
            ]);
        }

        // 🔹 Jika bukan AJAX → kirim ke view
        return view('pages.client.all_class', compact('courses', 'categories', 'promos'));
    }



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
