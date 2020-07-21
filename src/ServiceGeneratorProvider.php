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
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/commands' => base_path('app/Console/Commands/')
        ], "service-generator");

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateNewService::class,
            ]);
        }
    }
}