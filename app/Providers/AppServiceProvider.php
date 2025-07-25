<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \URL::forceRootUrl(config('app.url'));
        $this->app['request']->server->set('HTTPS','on');
        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
            //  \URL::forceRootUrl(config('app.url'));
        }

    }
}
