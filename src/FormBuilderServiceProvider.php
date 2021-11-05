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
