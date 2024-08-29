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

        // Publikowanie migracji
        $this->publishes([
            __DIR__.'/../Migrations/' => database_path('migrations')
        ], 'migrations');

        // Publikowanie komend:
        $this->publishes([
            __DIR__.'/../Console/Commands/' => app_path('Console/Commands')
        ], 'commands');
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

        // Merging migrations
        $this->loadMigrationsFrom(
            __DIR__.'/../Migrations/', '2024_08_29_00001_create_orlen_paczka_locations_table'
        );
    }
}
