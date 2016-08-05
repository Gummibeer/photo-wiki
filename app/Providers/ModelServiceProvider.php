<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::created(function (User $user) {
            $user->allow('edit', $user);
        });
        Event::updated(function (Event $event) {
            if ($event->hasGoogleEvent()) {
                $event->updateGoogleEvent();
            }
        });
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
