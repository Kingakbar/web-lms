<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientSideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ambil kursus terbaru (misalnya 6 course saja)
        $courses = Course::with('instructor', 'category', 'reviews')
            ->latest()
            ->take(6)
            ->get();

        return view('pages.client.landing_page', compact('courses'));
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
