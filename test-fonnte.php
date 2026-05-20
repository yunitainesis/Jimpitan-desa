<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$token = \App\Models\Setting::get('fonnte_token');
$res = \Illuminate\Support\Facades\Http::withHeaders(['Authorization' => $token])->post('https://api.fonnte.com/send', ['target' => '081234567890', 'message' => 'test']);
echo "TOKEN: " . $token . "\n";
echo "RESPONSE: " . $res->body() . "\n";
