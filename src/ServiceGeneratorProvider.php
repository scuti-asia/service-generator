<?php

namespace Scuti\Admin\ServiceGenerator;

use Illuminate\Support\ServiceProvider;

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
    }
}