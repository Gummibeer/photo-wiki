<?php

namespace App\Console\Commands;

use App\Console\Command;
use App\Models\Event;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event as GoogleEvent;

class ReindexCalendar extends Command
{
    protected $signature = 'calendar:reindex';
    protected $description = 'Reindex all events to algolia search.';

    public function handle()
    {
        $this->logCall();

        $this->info('reindex algolia search');
        Event::reindex();
    }
}
