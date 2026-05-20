<?php

namespace App\Http\Controllers;

use App\Models\WaNotification;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(private WhatsAppService $waService) {}

    public function index(Request $request)
    {
        $week = $request->get('week', now()->weekOfYear);
        $year = $request->get('year', now()->year);

        $notifications = WaNotification::with('house')
            ->where('week_number', $week)
            ->where('year', $year)
            ->orderByDesc('sent_at')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'sent'    => WaNotification::where('week_number', $week)->where('year', $year)->where('status', 'sent')->count(),
            'failed'  => WaNotification::where('week_number', $week)->where('year', $year)->where('status', 'failed')->count(),
            'pending' => WaNotification::where('week_number', $week)->where('year', $year)->where('status', 'pending')->count(),
        ];

        return view('notifications.index', compact('notifications', 'stats', 'week', 'year'));
    }

    public function sendBlast(Request $request)
    {
        $week = now()->weekOfYear;
        $year = now()->year;

        $result = $this->waService->sendBulkReminder($week, $year);

        $message = "Pengingat terkirim: {$result['sent']} berhasil, {$result['failed']} gagal";
        if ($result['skipped'] > 0) {
            $message .= ", {$result['skipped']} dilewati (no. HP tidak ada)";
        }

        return redirect()->route('notifications.index')
            ->with('success', $message);
    }

    public function sendSingle(Request $request)
    {
        $request->validate([
            'house_id' => 'required|exists:houses,id',
        ]);

        $house = \App\Models\House::findOrFail($request->house_id);

        if (empty($house->phone_number)) {
            return back()->with('error', 'Nomor HP rumah ini belum diisi.');
        }

        $week = now()->weekOfYear;
        $year = now()->year;

        $notification = $this->waService->sendJimpitanReminder($house, $week, $year);

        if ($notification->status === 'sent') {
            return back()->with('success', "Pengingat WA berhasil dikirim ke {$house->owner_name}!");
        } else {
            return back()->with('error', "Gagal mengirim WA: " . $notification->error_message);
        }
    }
}
