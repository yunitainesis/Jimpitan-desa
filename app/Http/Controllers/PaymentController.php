<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function scan()
    {
        return view('payments.scan');
    }

    /**
     * Proses scan QR code (dipanggil via AJAX dari halaman scan)
     */
    public function processQr(Request $request)
    {
        $request->validate([
            'qr_token' => 'required|string',
            'status'   => 'nullable|in:paid,unpaid',
        ]);

        $house = House::where('qr_token', $request->qr_token)
            ->where('is_active', true)
            ->first();

        if (!$house) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak dikenal atau rumah tidak aktif.',
            ], 404);
        }

        $week = now()->weekOfYear;
        $year = now()->year;

        // Jika status belum dipilih dari prompt, kembalikan data rumah
        if (!$request->has('status')) {
            return response()->json([
                'success' => true,
                'prompt_status' => true,
                'house' => $house
            ]);
        }

        // Jika dipilih Belum/Kosong, kirim pesan WA
        if ($request->status === 'unpaid') {
            $notification = app(\App\Services\WhatsAppService::class)->sendJimpitanReminder($house, $week, $year);
            
            if ($notification->status === 'failed') {
                return response()->json([
                    'success' => false,
                    'message' => "Gagal mengirim pesan WA ke Rumah {$house->house_number}. Periksa Token Fonnte atau nomor HP.",
                    'house'   => $house,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => "Pesan pengingat WhatsApp telah berhasil dikirim ke Rumah {$house->house_number} ({$house->owner_name}).",
                'house'   => $house,
            ]);
        }

        $week = now()->weekOfYear;
        $year = now()->year;

        // Cek apakah sudah bayar minggu ini
        $existing = Payment::where('house_id', $house->id)
            ->where('week_number', $week)
            ->where('year', $year)
            ->first();

        if ($existing) {
            return response()->json([
                'success'  => false,
                'already_paid' => true,
                'message'  => "Rumah {$house->house_number} ({$house->owner_name}) sudah membayar minggu ini pada " . $existing->paid_at->format('d M Y H:i'),
                'house'    => $house,
            ]);
        }

        // Catat pembayaran
        $payment = Payment::create([
            'house_id'    => $house->id,
            'week_number' => $week,
            'year'        => $year,
            'paid_at'     => now(),
            'recorded_by' => Auth::id(),
            'amount'      => 1000,
        ]);

        return response()->json([
            'success' => true,
            'message' => "✅ Pembayaran Rumah {$house->house_number} ({$house->owner_name}) berhasil dicatat!",
            'house'   => $house,
            'payment' => $payment,
        ]);
    }

    public function history(Request $request)
    {
        $week = $request->get('week', now()->weekOfYear);
        $year = $request->get('year', now()->year);

        $payments = Payment::with('house', 'recorder')
            ->where('week_number', $week)
            ->where('year', $year)
            ->orderByDesc('paid_at')
            ->paginate(20)
            ->withQueryString();

        return view('payments.history', compact('payments', 'week', 'year'));
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return back()->with('success', 'Data pembayaran berhasil dihapus.');
    }
}
