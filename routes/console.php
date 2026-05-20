<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

// Jadwalkan pengingat otomatis di hari Sabtu jam 4 sore (16:00)
Schedule::command('jimpitan:remind-saturday')->saturdays()->at('16:00');
