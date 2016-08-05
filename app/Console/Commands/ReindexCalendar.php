<?php

namespace App\Console\Commands;

use App\Console\Command;
use App\Models\Event;

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
