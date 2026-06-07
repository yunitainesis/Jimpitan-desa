<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\House;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $monthlyReport = Payment::with('house')
            ->whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->select('house_id', DB::raw('count(*) as total_payments'), DB::raw('sum(amount) as total_amount'))
            ->groupBy('house_id')
            ->get();

        // Pemasukan Periode Ini
        $totalCollected = $monthlyReport->sum('total_amount');
        
        // Pengeluaran Periode Ini
        $totalExpenses = Expense::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('amount');

        // Sisa Kas Periode Ini
        $saldoPeriode = $totalCollected - $totalExpenses;

        // Detail Pengeluaran Periode Ini
        $monthlyExpenses = Expense::with('recorder')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date')
            ->get();

        // Kumulatif / Saldo Kas Keseluruhan
        $totalCollectedAllTime = Payment::sum('amount');
        $totalExpensesAllTime = Expense::sum('amount');
        $saldoKasAllTime = $totalCollectedAllTime - $totalExpensesAllTime;
        
        return view('reports.index', compact(
            'monthlyReport', 
            'totalCollected', 
            'totalExpenses', 
            'saldoPeriode', 
            'monthlyExpenses',
            'totalCollectedAllTime',
            'totalExpensesAllTime',
            'saldoKasAllTime',
            'year', 
            'month'
        ));
    }
}
