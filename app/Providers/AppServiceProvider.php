<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use App\Events\UserLoggedIn;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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


        Str::macro('loggedUserName', function () {
            $user = Auth::user();

            if ($user && $user->name) {
                return strtolower($user->name);
            }

            return 'GUEST';
       });
    }
}
