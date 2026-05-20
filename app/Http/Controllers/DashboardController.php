<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Payment;
use App\Models\WaNotification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $week = now()->weekOfYear;
        $year = now()->year;

        $totalHouses  = House::where('is_active', true)->count();
        $paidThisWeek = Payment::where('week_number', $week)->where('year', $year)->count();
        $unpaidCount  = $totalHouses - $paidThisWeek;

        $recentPayments = Payment::with('house', 'recorder')
            ->orderByDesc('paid_at')
            ->limit(10)
            ->get();

        $unpaidHouses = House::where('is_active', true)
            ->whereDoesntHave('payments', function ($q) use ($week, $year) {
                $q->where('week_number', $week)->where('year', $year);
            })
            ->get();

        $totalNotifSent = WaNotification::where('week_number', $week)
            ->where('year', $year)
            ->where('status', 'sent')
            ->count();

        // Calculate total balance
        $totalCollected = Payment::sum('amount');
        $totalExpenses = \App\Models\Expense::sum('amount');
        $saldoKas = $totalCollected - $totalExpenses;

        return view('dashboard.index', compact(
            'totalHouses', 'paidThisWeek', 'unpaidCount',
            'recentPayments', 'unpaidHouses', 'week', 'year', 'totalNotifSent', 'saldoKas'
        ));
    }
}
