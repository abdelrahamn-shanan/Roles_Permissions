<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MailService;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // bind 
        $this->app->bind('MailService', function ($app) {
            return new MailService();
        });
        // // Singleton binding
        // $this->app->singleton(MailService::class, function ($app) {
        //     return new MailService();
        // });

        // // Instance binding
        // $mailServiceInstance = new MailService();
        // $this->app->instance('MailServiceInstance', $mailServiceInstance);

        // // Interface to implementation binding (assuming MailServiceInterface exists)
        // $this->app->bind(\App\Contracts\MailServiceInterface::class, MailService::class);

        // // Contextual binding (example: when SomeClass needs MailServiceInterface, give MailService)
        // $this->app->when(\App\SomeClass::class)
        //     ->needs(\App\Contracts\MailServiceInterface::class)
        //     ->give(function ($app) {
        //         return $app->make(MailService::class);
        //     });

        // // Tagging binding (tagging MailService for later resolution)
        // $this->app->tag([MailService::class], 'mail_services');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
