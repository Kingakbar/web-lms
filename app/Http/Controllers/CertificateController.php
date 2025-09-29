<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil enrollment user
        $enrollments = Enrollment::with(['course.lessons', 'lessonCompletions'])
            ->where('user_id', $user->id)
            ->get();

        // Cek mana yang sudah selesai 100%
        $data = $enrollments->map(function ($enrollment) {
            $totalLessons = $enrollment->course->lessons->count();
            $completed = $enrollment->lessonCompletions->where('is_completed', true)->count();

            $isCompleted = $totalLessons > 0 && $completed === $totalLessons;

            return [
                'enrollment' => $enrollment,
                'isCompleted' => $isCompleted,
                'certificate' => $enrollment->certificate,
            ];
        });

        return view('pages.student.sertifikat.sertifikat_page', compact('data'));
    }

    public function generate($enrollmentId)
    {
        // Ambil enrollment + relasi yang diperlukan
        $enrollment = Enrollment::with(['course.lessons', 'user', 'lessonCompletions', 'certificate'])
            ->findOrFail($enrollmentId);

        // Cek apakah user pemilik enrollment
        if ($enrollment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Hitung progress
        $totalLessons = $enrollment->course->lessons->count();
        $completedLessons = $enrollment->lessonCompletions->where('is_completed', true)->count();

        if ($totalLessons === 0 || $completedLessons < $totalLessons) {
            return redirect()->back()->with('error', 'Kursus belum selesai.');
        }

        // Buat sertifikat kalau belum ada (hanya untuk tracking)
        if (!$enrollment->certificate) {
            $certificate = Certificate::create([
                'enrollment_id'     => $enrollment->id,
                'certificate_number' => 'CERT-' . strtoupper(uniqid()),
                'issued_at'         => now(),
                'file_path'         => null,
            ]);
        } else {
            $certificate = $enrollment->certificate;
        }

        // Convert logo ke base64 untuk embedding di PDF
        $logoPath = public_path('assets/img/logo.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        // Convert signature ke base64
        $signaturePath = public_path('signature.png');
        $signatureBase64 = '';
        if (file_exists($signaturePath)) {
            $signatureBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($signaturePath));
        }

        // Generate PDF dengan konfigurasi khusus
        $pdf = Pdf::loadView('pages.student.certificates.pdf', [
            'user'            => $enrollment->user,
            'course'          => $enrollment->course,
            'certificate'     => $certificate,
            'logoBase64'      => $logoBase64,
            'signatureBase64' => $signatureBase64,
        ])
            ->setPaper('a4', 'landscape')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        // Langsung download tanpa simpan ke storage
        return $pdf->download("Certificate-{$certificate->certificate_number}.pdf");
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
