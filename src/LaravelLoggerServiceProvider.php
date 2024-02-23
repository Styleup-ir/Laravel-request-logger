<?php

namespace Styleup\LaravelLogger;

use Illuminate\Support\ServiceProvider;
use Styleup\LaravelLogger\Middlewares\LaraverLoggerStyleup;

class LaravelLoggerServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'styleup');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'styleup');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        app('router')->aliasMiddleware('styleup-laravel-logger',LaraverLoggerStyleup::class);

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-logger.php', 'laravel-logger');

        // Register the service the package provides.
        $this->app->singleton('laravel-logger', function ($app) {
            return new LaravelLogger;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-logger'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravel-logger.php' => config_path('laravel-logger.php'),
        ], 'laravel-logger.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/styleup'),
        ], 'laravel-logger.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/styleup'),
        ], 'laravel-logger.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/styleup'),
        ], 'laravel-logger.lang');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
