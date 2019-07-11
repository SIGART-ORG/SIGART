<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Slug;

class SlugSigart extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton( Connection::class, function( $app) {
            return new Slug();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
