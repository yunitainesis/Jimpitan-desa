<?php

namespace App\Services;

use App\Models\House;
use App\Models\Setting;
use App\Models\WaNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private string $apiUrl = 'https://api.fonnte.com/send';
    private string $token;

    public function __construct()
    {
        // Ambil token dari tabel settings, bukan dari config file.
        // Gunakan ?? '' untuk memastikan tipe datanya adalah string (bukan null)
        $this->token = Setting::get('fonnte_token', config('services.fonnte.token', '')) ?? '';
    }

    /**
     * Kirim pesan WA ke satu nomor
     */
    public function sendMessage(?string $phone, string $message): array
    {
        if (empty($phone)) {
            Log::warning("Mencoba mengirim WA tapi nomor HP kosong.");
            return ['status' => false, 'detail' => 'Nomor HP tidak tersedia'];
        }
        // Mode simulasi jika token tidak dikonfigurasi
        if (empty($this->token) || $this->token === 'your-fonnte-token') {
            Log::info("WA SIMULASI ke {$phone}: {$message}");
            return ['status' => true, 'simulated' => true];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post($this->apiUrl, [
                'target'  => $phone,
                'message' => $message,
            ]);

            $result = $response->json();
            
            Log::info("Fonnte API Response:", ['phone' => $phone, 'response' => $result]);

            return [
                'status' => $result['status'] ?? false,
                'detail' => $result['detail'] ?? ($result['reason'] ?? 'No detail'),
            ];
        } catch (\Exception $e) {
            Log::error("WhatsApp error: " . $e->getMessage());
            return ['status' => false, 'detail' => $e->getMessage()];
        }
    }

    /**
     * Kirim pengingat jimpitan ke satu rumah
     */
    public function sendJimpitanReminder(House $house, int $week, int $year): WaNotification
    {
        $template = Setting::get('wa_message_template',
            "Yth. Bapak/Ibu *{nama}*,\n\n" .
            "Kami dari Pengurus {rt} menginformasikan bahwa pada periode penarikan minggu ini, kotak jimpitan di kediaman Bapak/Ibu (No. {no_rumah}) belum terisi.\n\n" .
            "Untuk menjaga kelancaran program lingkungan, kami memohon kesediaan Bapak/Ibu untuk melengkapi iuran jimpitan pada minggu berikutnya sebesar 2 kali lipat, yaitu sejumlah *Rp 4.000*.\n\n" .
            "Atas perhatian dan kerja samanya, kami ucapkan terima kasih.\n\n" .
            "Hormat kami,\n_Pengurus {rt}_"
        );

        $nominal = Setting::get('amount_per_week', 1000);
        $rtName  = Setting::get('rt_name', 'RT');

        $message = str_replace(
            ['{nama}', '{minggu}', '{tahun}', '{nominal}', '{rt}', '{no_rumah}'],
            [$house->owner_name, $week, $year, number_format($nominal, 0, ',', '.'), $rtName, $house->house_number],
            $template
        );

        $notification = WaNotification::create([
            'house_id'    => $house->id,
            'phone_number' => $house->phone_number,
            'week_number' => $week,
            'year'        => $year,
            'message'     => $message,
            'status'      => 'pending',
        ]);

        $result = $this->sendMessage($house->phone_number, $message);

        $notification->update([
            'status'        => $result['status'] ? 'sent' : 'failed',
            'error_message' => $result['status'] ? null : ($result['detail'] ?? 'Unknown error'),
            'sent_at'       => now(),
        ]);

        return $notification->fresh();
    }

    /**
     * Kirim pengingat ke semua rumah yang belum bayar minggu ini
     */
    public function sendBulkReminder(int $week, int $year): array
    {
        $unpaidHouses = House::where('is_active', true)
            ->whereNotNull('phone_number')
            ->whereDoesntHave('payments', function ($q) use ($week, $year) {
                $q->where('week_number', $week)->where('year', $year);
            })
            ->get();

        $sent   = 0;
        $failed = 0;
        $skipped = 0;

        foreach ($unpaidHouses as $house) {
            if (empty($house->phone_number)) {
                $skipped++;
                continue;
            }

            $notification = $this->sendJimpitanReminder($house, $week, $year);

            if ($notification->status === 'sent') {
                $sent++;
            } else {
                $failed++;
            }

            // Jeda 1 detik antar pesan agar tidak spam
            sleep(1);
        }

        return compact('sent', 'failed', 'skipped');
    }
}
