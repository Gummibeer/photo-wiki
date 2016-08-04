<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function getIndex()
    {
        $calendar = \Calendar::setOptions([
            'firstDay' => 1,
            'timeFormat' => 'H:mm',
            'lang' => 'de',
            'header' => [
                'left' => 'title',
                'center' => '',
                'right' => 'month,agendaWeek,agendaDay, today, prev,next',
            ],
        ])
            ->setCallbacks([
                'eventClick' => 'function(calEvent, jsEvent, view){ console.log(calEvent); calendar.fn.eventClick(calEvent, jsEvent, view); }',
            ]);

        $calendars = \Datamap::getCalendars();
        foreach ($calendars as $config) {
            $events = Event::byTimeFrame()->byGcId($config['gcid'])->byApproved()->get();
            $calendar->addEvents($events, [
                'color' => $config['color']['hex'],
            ]);
        }

        return view('app.event.index')->with([
            'calendar' => $calendar,
            'calendars' => $calendars,
        ]);
    }

    public function getShow(Request $request, Event $event)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return $event;
        }

        return view('app.event.show')->with([
            'event' => $event,
        ]);
    }

    public function getReload(Request $request, Event $event)
    {
        $event->reloadGoogleEvent();

        return redirect()->back();
    }
}
