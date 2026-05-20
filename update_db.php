<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$template = "Yth. Bapak/Ibu *{nama}*,

Kami dari Pengurus {rt} menginformasikan bahwa pada periode penarikan minggu ini, kotak jimpitan di kediaman Bapak/Ibu (No. {no_rumah}) belum terisi.

Untuk menjaga kelancaran program lingkungan, kami memohon kesediaan Bapak/Ibu untuk melengkapi iuran jimpitan pada minggu berikutnya sebesar 2 kali lipat, yaitu sejumlah *Rp 4.000*.

Atas perhatian dan kerja samanya, kami ucapkan terima kasih.

Hormat kami,
_Pengurus {rt}_";

\App\Models\Setting::set('wa_message_template', $template);
echo "Database updated!\n";
