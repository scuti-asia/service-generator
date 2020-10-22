<?php

namespace Scuti\Admin\ServiceGenerator;

use Illuminate\Support\ServiceProvider;
use Scuti\Admin\ServiceGenerator\Commands\CreateNewService;

class ServiceGeneratorProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/service_layer.php', 'service-generator');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__. '/config' => base_path('config/')
        ], "service-generator");

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateNewService::class
            ]);
        }
    }
}
