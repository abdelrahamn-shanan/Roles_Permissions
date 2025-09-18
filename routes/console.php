<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\DailyUsersReport;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('greet {name}', function ($name) {
    $this->info("Hello, {$name}! Welcome to Laravel 12.");
});

Schedule::command('report:daily-users')
    ->everyTwoMinutes();





