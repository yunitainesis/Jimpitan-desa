<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;

class SendSaturdayReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jimpitan:remind-saturday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim otomatis pengingat WA jimpitan pada hari Sabtu untuk minggu yang bersangkutan';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppService $waService)
    {
        $this->info("Memulai pengiriman pengingat WhatsApp hari Sabtu...");

        // Ambil data minggu ini (Karena dikirim hari sabtu, ini masih dalam minggu yang sama dengan pengumpulan jimpitan kemarin/minggu lalu)
        $week = now()->weekOfYear;
        $year = now()->year;

        $this->info("Memproses rumah yang belum bayar di minggu ke-{$week} tahun {$year}...");

        $result = $waService->sendBulkReminder($week, $year);

        $this->info("Selesai! Berhasil: {$result['sent']}, Gagal: {$result['failed']}, Dilewati (Tanpa No HP): {$result['skipped']}");
    }
}
