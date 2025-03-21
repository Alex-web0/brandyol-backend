<?php

use App\Jobs\LogAnalytics;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// TO RUN LOCALLY USE : php artisan schedule:work

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

/// Calls the logging of analytics job, hourly
Schedule::job(new LogAnalytics)->hourly();
