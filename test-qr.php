<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $png = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(100)->generate('test');
    echo strlen($png) > 0 ? "PNG OK" : "PNG FAIL";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage();
}
