<?php

namespace VincenzoGambino\LaraTok;

use Illuminate\Support\ServiceProvider;

class LaraTokServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish Configuration
        $this->publishes([
          __DIR__.'/Config/laratok.php' => config_path('laratok.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

      // Config
      $this->mergeConfigFrom( __DIR__ . '/Config/laratok.php', 'laratok');

      $this->app->bind('vincenzogambino-laratok', function() {
        return new LaraTok;
      });
    }
}
