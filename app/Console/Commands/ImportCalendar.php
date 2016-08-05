<?php

namespace App\Console\Commands;

use App\Console\Command;
use App\Models\Event;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event as GoogleEvent;

class ImportCalendar extends Command
{
    protected $signature = 'calendar:import {calendar?} {--geid=} {--force}';
    protected $description = 'Imports all events from all configured Google Calendars.';

    public function handle()
    {
        $this->logCall();

        $calendarName = $this->argument('calendar');

        $force = (bool)$this->option('force');

        if (is_null($calendarName)) {
            $calendars = \Datamap::getCalendars()->pluck('gcid', 'name');

            foreach ($calendars as $name => $gcid) {
                $this->processCalendar($name, $force);
            }
        } else {
            $geid = $this->option('geid');
            if (! empty($geid)) {
                $gcid = \Datamap::getCalendarByName($calendarName)['gcid'];
                $gEvent = GoogleEvent::find($geid, $gcid);
                $this->processEvent($gcid, $gEvent, true);
            } else {
                $this->processCalendar($calendarName, $force);
            }
        }
    }

    protected function processCalendar($name, $force = false)
    {
        $gcid = \Datamap::getCalendarByName($name)['gcid'];

        $this->comment("fetch all events for [$name]($gcid)");
        $gEvents = GoogleEvent::get($this->getStart(), $this->getEnd(), [], $gcid);
        foreach ($gEvents as $gEvent) {
            $this->processEvent($gcid, $gEvent, $force);
        }
    }

    protected function processEvent($gcid, GoogleEvent $gEvent, $force = false)
    {
        $geid = $gEvent->id;
        $name = $gEvent->name;
        $this->comment("process event [$name]($geid)");
        $event = Event::byGcId($gcid)->byGeId($geid)->first();
        if (is_null($event) || $force) {
            if(is_null($event)) {
                $event = new Event();
            }
            $success = Event::importGoogleEvent($event, $gcid, $gEvent);
            if ($success) {
                $this->info("imported event [$name]($geid)");
            } else {
                $this->error("failed event [$name]($geid)");
            }
        } else {
            $this->info("ignored event [$name]($geid)");
        }
    }

    protected function getStart()
    {
        return Carbon::yesterday('UTC')->startOfMonth();
    }

    protected function getEnd()
    {
        return Carbon::now('UTC')->addYear()->endOfDay();
    }
}
