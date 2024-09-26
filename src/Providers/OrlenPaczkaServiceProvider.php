<?php

namespace Mindgoner\LaravelOrlenPaczka\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class OrlenPaczkaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishing configuration
        $this->publishes([
            __DIR__.'/../Config/orlen-paczka.php' => config_path('orlen-paczka.php'),
        ], 'config');

        // Publishing migrations
        $this->publishes([
            __DIR__.'/../Migrations/' => database_path('migrations')
        ], 'migrations');

        // Publishing commands
        $this->publishes([
            __DIR__.'/../Console/Commands/' => app_path('Console/Commands')
        ], 'commands');

        // Registering Blade Directives with map:
        Blade::directive('OPMap', function ($expression) {
            $token = config('orlenpaczka.MapToken', '');
            $apihost = "https://mapa.orlenpaczka.pl/";

            return <<<EOT
<script>
(function (o, r, l, e, n) {
o[l] = o[l] || [];
var f = r.getElementsByTagName('head')[0];
var j = r.createElement('script');
j.async = true;
j.src = e + 'widget.js?token=' + n + '&v=1.0.0&t=' + Math.floor(new Date().getTime() / 1000);
f.insertBefore(j, f.firstChild);
})(window, document, 'orlenpaczka', '{$apihost}', '{$token}');
</script>
EOT;
        });

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
