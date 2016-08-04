<?php
namespace App\Console\Commands;

use App\Console\Command;
use App\Models\Event;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event as GoogleEvent;

class ImportCalendar extends Command
{
    protected $signature = 'calendar:import';
    protected $description = 'Imports all events from all configured Google Calendars.';

    public function handle()
    {
        $this->logCall();

        $start = Carbon::yesterday('UTC')->startOfMonth();
        $end = Carbon::now('UTC')->addYear()->endOfDay();

        $calendars = \Datamap::getCalendars()->pluck('gcid', 'name');

        $eventIds = [];
        foreach($calendars as $name => $gcid) {
            $this->comment("fetch all events for [$name]($gcid)");
            $gEvents = GoogleEvent::get($start, $end, [], $gcid);
            foreach($gEvents as $gEvent) {
                $geid = $gEvent->id;
                $name = $gEvent->name;
                $this->comment("process event [$name]($geid)");
                $event = Event::byGcId($gcid)->byGeId($geid)->first() ?: new Event();
                $success = Event::importGoogleEvent($event, $gcid, $gEvent);
                if($success) {
                    $this->info("imported event [$name]($geid)");
                    $eventIds[] = $event->getKey();
                } else {
                    $this->error("failed event [$name]($geid)");
                }
            }
        }

        $this->info('unapprove all not google events');
        Event::whereNotIn('id', $eventIds)->update(['approved' => 0]);
        $this->info('reindex algolia search');
        Event::reindex();
    }
}
