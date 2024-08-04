<?php

namespace Modules\Frontend\Providers;


use Illuminate\Support\ServiceProvider;

class FrontendServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutes();
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'frontend');
    }

    /**
     * Register the backend routes.
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
    }
}