<?php

namespace App\Providers;
use Vonage\Client\Credentials\Basic;
use Illuminate\Support\Facades\Notification;
use Vonage\Client;
use Illuminate\Support\ServiceProvider;

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
        Notification::extend('vonage', function ($app) {
        $basic  = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
        return new \Illuminate\Notifications\Channels\VonageSmsChannel(new Client($basic), env('VONAGE_SMS_FROM'));
    });
    }
}
