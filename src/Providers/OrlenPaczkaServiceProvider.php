<?php

namespace Mindgoner\LaravelOrlenPaczka\Providers;

use Illuminate\Support\ServiceProvider;

class OrlenPaczkaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publikowanie konfiguracji
        $this->publishes([
            __DIR__.'/../Config/orlen-paczka.php' => config_path('orlen-paczka.php'),
        ], 'config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Merging configuration
        $this->mergeConfigFrom(
            __DIR__.'/../Config/orlen-paczka.php', 'orlen-paczka'
        );
    }
}
