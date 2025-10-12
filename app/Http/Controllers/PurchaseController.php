<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function detail($slug)
    {
        $course = Course::with(['instructor', 'lessons', 'reviews.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        $isEnrolled = false;
        if (Auth::check()) {
            $isEnrolled = Enrollment::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->exists();
        }

        return view('pages.client.beli_course_page', compact('course', 'isEnrolled'));
    }


    public function processPayment(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'method' => 'required|in:qris,transfer,cash',
        ]);

        $user = Auth::user();

        // Cek atau buat enrollment baru
        $enrollment = Enrollment::firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $request->course_id,
            ],
            [
                'enrolled_at' => now(),
            ]
        );

        // Catat pembayaran baru (status default: pending)
        $payment = Payment::create([
            'enrollment_id' => $enrollment->id,
            'amount' => $request->amount ?? $enrollment->course->price,
            'method' => $request->method,
            'status' => 'pending',
            'paid_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dicatat. Silakan kirim bukti ke admin untuk verifikasi.',
            'payment' => $payment,
        ]);
    }

    public function checkout(Course $course)
    {
        // Cek apakah user sudah terdaftar
        $isEnrolled = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->exists();

        if ($isEnrolled) {
            return redirect()->route('dashboard.student')
                ->with('info', 'Kamu sudah terdaftar di kursus ini.');
        }

        // Ambil semua promo yang masih aktif berdasarkan tanggal
        $promos = Promo::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->orderBy('start_date', 'desc')
            ->get();

        // Kirim data ke view
        return view('pages.client.payment_checkout', compact('course', 'promos'));
    }
}
