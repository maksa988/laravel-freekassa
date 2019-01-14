<?php

namespace Maksa988\FreeKassa;

use Illuminate\Support\ServiceProvider;

class FreeKassaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/freekassa.php' => config_path('freekassa.php'),
        ], 'config');

        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/freekassa.php', 'freekassa');

        $this->app->singleton('freekassa', function () {
            return $this->app->make(FreeKassa::class);
        });

        $this->app->alias('freekassa', 'FreeKassa');

        //
    }
}
