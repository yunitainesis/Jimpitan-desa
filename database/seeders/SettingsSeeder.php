<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'amount_per_week',
                'value' => '1000',
                'description' => 'Besar iuran jimpitan per minggu'
            ],
            [
                'key' => 'rt_name',
                'value' => 'RT 05 RW 02',
                'description' => 'Nama RT/Lingkungan'
            ],
            [
                'key' => 'wa_message_template',
                'value' => "Assalamu'alaikum Bapak/Ibu *{nama}* 🙏\n\nIni pengingat dari Pengurus {rt} bahwa iuran *Jimpitan Minggu ke-{minggu} Tahun {tahun}* sebesar *Rp {nominal}* belum tercatat.\n\nMohon segera isi kotak jimpitan di depan rumah Anda ya 😊\n\nTerima kasih atas partisipasinya 🌿\n_Pengurus RT_",
                'description' => 'Template pesan WhatsApp pengingat'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
