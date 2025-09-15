<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use App\Events\UserLoggedIn;
use App\Listeners\SendWelcomeEmail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
        return $user->hasRole('admin') ? true : null;
        });

        Event::listen(
            UserLoggedIn::class,
            [SendWelcomeEmail::class, 'handle']
        );
    }
}
