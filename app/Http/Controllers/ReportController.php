<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\House;
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

        $totalCollected = $monthlyReport->sum('total_amount');
        
        return view('reports.index', compact('monthlyReport', 'totalCollected', 'year', 'month'));
    }
}
