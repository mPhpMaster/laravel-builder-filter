<?php

namespace mPhpMaster\BuilderFilter;

use Illuminate\Support\ServiceProvider;

class BuilderFilterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole() && function_exists('config_path')) {
            $this->publishes([
                __DIR__.'/../config/builder-filter.php' => config_path('builder-filter.php'),
            ], 'config');
        }

        $this->mergeConfigFrom(__DIR__.'/../config/builder-filter.php', 'builder-filter');
    }

    public function register()
    {
        $this->app->bind(BuilderFilterRequest::class, function ($app) {
            return BuilderFilterRequest::fromRequest($app['request']);
        });
    }

    public function provides()
    {
        // TODO: implement DeferrableProvider when Laravel 5.7 support is dropped.

        return [
            BuilderFilterRequest::class,
        ];
    }
}
