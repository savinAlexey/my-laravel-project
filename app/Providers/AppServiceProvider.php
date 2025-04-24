<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('yookassa', function() {
            $client = new \YooKassa\Client();
            $client->setAuth(
                config('services.yookassa.shop_id'),
                config('services.yookassa.secret_key')
            );
            return $client;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
