<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TranscationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Payment::with(['enrollment.user', 'enrollment.course'])
            ->latest()
            ->paginate(10);

        return view('pages.admin.transaction.transaction_index', compact('transactions'));
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
    public function edit(Payment $transaction)
    {
        $transaction->load(['enrollment.user', 'enrollment.course']);
        return view('pages.admin.transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed'
        ]);

        $transaction->update([
            'status' => $request->status
        ]);

        return redirect()->route('transactions.index')->with('success', 'Status transaksi berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
