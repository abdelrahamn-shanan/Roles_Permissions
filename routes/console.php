<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('greet {name}', function ($name) {
    $this->info("Hello, {$name}! Welcome to Laravel 12.");
});





