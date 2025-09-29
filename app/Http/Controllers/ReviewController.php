<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $instructor = Auth::user();

        // Ambil semua review untuk kursus yang dimiliki instruktur
        $reviews = Review::with(['user', 'course'])
            ->whereHas('course', function ($query) use ($instructor) {
                $query->where('user_id', $instructor->id);
            })
            ->latest()
            ->paginate(10);

        // Statistik ringkasan review
        $totalReviews = $reviews->total();
        $averageRating = Review::whereHas('course', function ($query) use ($instructor) {
            $query->where('user_id', $instructor->id);
        })->avg('rating');

        $ratingDistribution = Review::selectRaw('rating, COUNT(*) as count')
            ->whereHas('course', function ($query) use ($instructor) {
                $query->where('user_id', $instructor->id);
            })
            ->groupBy('rating')
            ->pluck('count', 'rating');

        return view('pages.instructor.review.review', compact(
            'instructor',
            'reviews',
            'totalReviews',
            'averageRating',
            'ratingDistribution'
        ));
    }
}
