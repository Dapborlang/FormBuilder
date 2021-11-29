<?php

namespace Rdmarwein\Formbuilder;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class FormBuilderServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'formbuilder');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $router = $this->app->make(Router::class);
        $this->publishes([
            __DIR__.'/assets' => public_path('rdmarwein/formgen'),
        ], 'public');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
