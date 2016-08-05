<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Event\CreateRequest;
use App\Http\Requests\App\Event\EditRequest;
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
        $this->authorize('edit', $event);

        $event->reloadGoogleEvent();

        return redirect()->back();
    }

    public function getApprove(Request $request, Event $event)
    {
        $this->authorize('approve', $event);

        $event->approve();

        return redirect()->back();
    }

    public function getCreate(Request $request)
    {
        return view('app.event.create')->with([
            'event' => new Event(),
            'calendars' => \Datamap::getCalendars()->pluck('display_name', 'name'),
        ]);
    }

    public function postCreate(CreateRequest $request)
    {
        $data = array_filter($request->only(Event::getFillableFields()), function ($value) {
            return ! is_null($value);
        });
        $data['google_calendar_id'] = \Datamap::getCalendarByName($request->get('calendar', 'default'))['gcid'];

        $event = Event::create($data);
        if (\Auth::check() && \Auth::user()->can('approve', Event::class)) {
            $event->approve();
        }

        Event::find($event->getKey())->update(['starting_at' => $data['starting_at']]);

        return redirect()->route('app.get.event.show', $event->getKey());
    }

    public function getEdit(Request $request, Event $event)
    {
        $this->authorize('edit', $event);

        return view('app.event.edit')->with([
            'event' => $event,
            'calendars' => \Datamap::getCalendars()->pluck('display_name', 'name'),
        ]);
    }

    public function postEdit(EditRequest $request, Event $event)
    {
        $this->authorize('edit', $event);

        $data = array_filter($request->only(Event::getFillableFields()), function ($value) {
            return ! is_null($value);
        });
        $data['google_calendar_id'] = \Datamap::getCalendarByName($request->get('calendar', 'default'))['gcid'];

        $event->update($data);

        return redirect()->route('app.get.event.show', $event->getKey());
    }
}
