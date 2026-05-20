<?php

namespace App\Console\Commands;

use App\Services\WhatsAppService;
use Illuminate\Console\Command;

class SendWeeklyReminder extends Command
{
    protected $signature = 'jimpitan:send-reminder {--dry-run : Only show what would be sent}';
    protected $description = 'Kirim pengingat WA mingguan ke rumah yang belum bayar';

    public function handle(WhatsAppService $waService)
    {
        $week = now()->weekOfYear;
        $year = now()->year;

        $this->info("Memulai pengiriman pengingat untuk Minggu ke-{$week}, {$year}...");

        if ($this->option('dry-run')) {
            $this->info("Mode simulasi (Dry Run) aktif.");
            return;
        }

        $result = $waService->sendBulkReminder($week, $year);

        $this->info("Selesai! Terkirim: {$result['sent']}, Gagal: {$result['failed']}, Dilewati: {$result['skipped']}");
    }
}
