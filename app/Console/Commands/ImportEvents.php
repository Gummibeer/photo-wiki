<?php

namespace App\Console\Commands;

use App\Console\Command;
use App\Models\Event;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Spatie\GoogleCalendar\Event as GoogleEvent;

class ImportEvents extends Command
{
    protected $signature = 'events:import';
    protected $description = 'Imports events from configured sources.';

    public function handle()
    {
        $this->logCall();
        
        foreach(get_class_methods($this) as $method) {
            if(starts_with($method, 'import')) {
                $this->$method();
            }
        }
    }

    protected function importHamburgCruiseCenter()
    {
        $this->info('import from hamburgcruisecenter.eu');

        $url = 'http://www.hamburgcruisecenter.eu/de/estimated-ships';
        $html = new \Htmldom($url);
        $rows = $html->find('#content table.views-table tr');
        foreach($rows as $row) {
            $event = new Event();
            $event->google_calendar_id = \Datamap::getCalendarByName('ships')['gcid'];
            $match = false;
            foreach($row->childNodes() as $cell) {
                $match = $this->hamburgcruisecenter_processTableCell($event, $cell) ? true : $match;
            }
            if($match) {
                $exists = Event::checkForExistence($event);
                if(!$exists) {
                    $event->save();
                    $this->info('created event #'.$event->getKey().' - '.$event->display_name);
                }
            }
        }
    }

    protected function hamburgcruisecenter_processTableCell(Event $event, $cell)
    {
        if($cell->tag == 'td') {
            if(str_contains($cell->class, 'views-field-field-shipname')) {
                $event->display_name = trim($cell->plaintext);
                $event->description = 'http://www.hamburgcruisecenter.eu'.$cell->children(0)->href;
                return true;
            }
            if(str_contains($cell->class, 'views-field-field-terminal')) {
                $event->location = $this->hamburgcruisecenter_getLocationByTerminal($cell->plaintext);
                return true;
            }
            if(str_contains($cell->class, 'views-field-field-arrival-departure-1')) {
                $event->ending_at = $this->hamburgcruisecenter_getCarbonByDate($cell->children(0));
                return true;
            }
            if(str_contains($cell->class, 'views-field-field-arrival-departure')) {
                $event->starting_at = $this->hamburgcruisecenter_getCarbonByDate($cell->children(0));
                return true;
            }
        }
    }

    protected function hamburgcruisecenter_getLocationByTerminal($terminal)
    {
        $terminal = strtolower(trim($terminal));
        switch ($terminal) {
            case 'hafencity':
                return 'Großer Grasbrook 19, Hamburg, Hamburg, Deutschland';
            case 'steinwerder':
                return 'Buchheisterstraße 16, Hamburg, Hamburg, Deutschland';
            case 'altona':
                return 'Van-der-Smissen-Straße 5, Hamburg, Hamburg, Deutschland';
        }
    }

    protected function hamburgcruisecenter_getCarbonByDate($element)
    {
        $timezone = 'Europe/Berlin';
        // 2. August 2016 - 8:00
        $text = trim($element->plaintext);
        $parts = explode(' ', $text);
        $day = intval($parts[0]);
        $month = $this->hamburgcruisecenter_getMonthByName($parts[1]);
        $year = intval($parts[2]);
        $time = explode(':', $parts[4]);
        $hour = intval($time[0]);
        $minute = intval($time[1]);
        return Carbon::create($year, $month, $day, $hour, $minute, 0, $timezone);
    }

    protected function hamburgcruisecenter_getMonthByName($month)
    {
        switch ($month) {
            case 'Januar':
                return 1;
            case 'Februar':
                return 2;
            case 'März':
                return 3;
            case 'April':
                return 4;
            case 'Mai':
                return 5;
            case 'Juni':
                return 6;
            case 'Juli':
                return 7;
            case 'August':
                return 8;
            case 'September':
                return 9;
            case 'Oktober':
                return 10;
            case 'November':
                return 11;
            case 'Dezember':
                return 12;
        }
    }
}
