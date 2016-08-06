<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\User;
use Fenos\Notifynder\Builder\Builder;
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
        Event::saving(function (Event $event) {
            if($event->isAllDay()) {
                $event->starting_at->startOfDay();
                $event->ending_at->endOfDay();
            }

            $event->starting_at->setTimezone('UTC');
            $event->ending_at->setTimezone('UTC');

            return true;
        });
        Event::created(function (Event $event) {
            if(!$event->approved && (\Auth::guest() || (\Auth::check() && !\Auth::user()->can('approve', $event)))) {
                $users = User::whereCan('approve', $event)->get();
                \Notifynder::loop($users, function (Builder $builder, User $user) use ($event) {
                    $builder
                        ->category('event.approve.required')
                        ->from($event)
                        ->to($user)
                        ->url(route('app.get.event.show', $event->getKey()));
                })->send();
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
