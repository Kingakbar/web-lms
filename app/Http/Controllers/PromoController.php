<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promos = Promo::latest()->paginate(10);
        return view('pages.admin.promo.promo_index', compact('promos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.promo.promo_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'               => 'required|string|max:255',
            'code'                => 'required|string|max:50|unique:promos,code',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_amount'     => 'nullable|numeric|min:0',
            'start_date'          => 'required|date',
            'end_date'            => 'required|date|after_or_equal:start_date',
        ]);

        Promo::create([
            'title'               => $request->title,
            'slug'                => Str::slug($request->title),
            'code'                => strtoupper($request->code),
            'discount_percentage' => $request->discount_percentage,
            'discount_amount'     => $request->discount_amount,
            'start_date'          => $request->start_date,
            'end_date'            => $request->end_date,
        ]);

        return redirect()->route('promos.index')->with('success', 'Promo berhasil dibuat!');
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
    public function edit(Promo $promo)
    {
        return view('pages.admin.promo.promo_edit', compact('promo'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'title'               => 'required|string|max:255',
            'code'                => 'required|string|max:50|unique:promos,code,' . $promo->id,
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_amount'     => 'nullable|numeric|min:0',
            'start_date'          => 'required|date',
            'end_date'            => 'required|date|after_or_equal:start_date',
        ]);

        $promo->update([
            'title'               => $request->title,
            'slug'                => Str::slug($request->title),
            'code'                => strtoupper($request->code),
            'discount_percentage' => $request->discount_percentage,
            'discount_amount'     => $request->discount_amount,
            'start_date'          => $request->start_date,
            'end_date'            => $request->end_date,
        ]);

        return redirect()->route('promos.index')->with('success', 'Promo berhasil diperbarui!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promo $promo)
    {
        $promo->delete();
        return redirect()->route('promos.index')->with('success', 'Promo berhasil dihapus!');
    }
}
