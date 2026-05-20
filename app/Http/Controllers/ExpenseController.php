<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $expenses = Expense::with('recorder')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->get();

        $totalExpense = $expenses->sum('amount');

        return view('expenses.index', compact('expenses', 'totalExpense', 'year', 'month'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric|min:1',
            'date'        => 'required|date',
        ]);

        Expense::create([
            'description' => $request->description,
            'amount'      => $request->amount,
            'date'        => $request->date,
            'recorded_by' => Auth::id(),
        ]);

        return back()->with('success', 'Data pengeluaran berhasil dicatat.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}
