<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule the job priority update command to run daily
Schedule::command('jobs:update-priority')->daily();

// Schedule daily job alerts to run at midnight (00:00)
Schedule::command('jobs:send-daily-alerts')->dailyAt('00:00');
