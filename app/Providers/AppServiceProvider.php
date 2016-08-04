<?php

namespace App\Providers;

use App\Libs\BouncerSeeder;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Bouncer::seeder(BouncerSeeder::class);
        Carbon::setLocale(\Helper::getLanguageFromLocale(\App::getLocale()));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
