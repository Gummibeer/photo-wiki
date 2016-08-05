<?php

namespace App\Console\Commands;

use App\Console\Command;
use App\Models\Event;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Spatie\GoogleCalendar\Event as GoogleEvent;

class ClearEvents extends Command
{
    protected $signature = 'events:clear';
    protected $description = 'Deletes all unapproved events.';

    public function handle()
    {
        $this->logCall();
//        $events = Event::byApproved(0)->get();
        $events = Event::where('id', '>=', 159)->get();
        foreach($events as $event) {
            $event->delete();
            $this->warn('deleted event #'.$event->getKey() . ' - ' . $event->display_name);
        }
    }
}
