<?php

namespace App\Console\Commands;

use App\Console\Command;
use App\Models\Event;

class ApproveEvents extends Command
{
    protected $signature = 'events:approve';
    protected $description = 'Approves all unapproved events.';

    public function handle()
    {
        $this->logCall();
        $events = Event::byApproved(0)->get();
        foreach ($events as $event) {
            $event->approve();
            $this->info('approved event #'.$event->getKey().' - '.$event->display_name);
        }
    }
}
