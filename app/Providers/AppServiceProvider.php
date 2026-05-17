<?php

namespace App\Providers;

use App\Services\CountryContext;
use App\Services\GeoLocator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CountryContext::class, function () {
            return new CountryContext();
        });

        $this->app->singleton(GeoLocator::class, function () {
            return new GeoLocator();
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
