<?php

namespace App\Providers;

use App\Libs\Datamap;
use App\Libs\Helper;
use Illuminate\Support\ServiceProvider;

class LibsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton(Datamap::class, function ($app) {
            return new Datamap();
        });
        $this->app->singleton(Helper::class, function ($app) {
            return new Helper();
        });
    }

    public function provides()
    {
        return [
            Datamap::class,
            Helper::class,
        ];
    }
}
