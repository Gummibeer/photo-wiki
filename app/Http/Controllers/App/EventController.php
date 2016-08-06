<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Event\CreateRequest;
use App\Http\Requests\App\Event\EditRequest;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function getIndex(Request $request)
    {
        $title = __('Kalender');
        if($request->has('date')) {
            $default = Carbon::createFromFormat('Y-m-d', $request->get('date'));
        } else {
            $default = Carbon::now();
        }
        if($request->has('calendar')) {
            $calendar = \Datamap::getCalendarByName($request->get('calendar'));
            $calendars[] = $calendar;
            $title = $calendar['display_name'] .' | ' . $title;
        } else {
            $calendars = \Datamap::getCalendars();
        }

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
                'eventClick' => 'function(calEvent, jsEvent, view){ calendar.fn.eventClick(calEvent, jsEvent, view); }',
                'eventAfterAllRender' => 'function(view){ view.calendar.gotoDate(moment(\''.$default->format('Y-m-d').'\')); }'
            ]);

        foreach ($calendars as $config) {
            $events = Event::byTimeFrame()->byGcId($config['gcid'])->byApproved()->get();
            $calendar->addEvents($events, [
                'color' => $config['color']['hex'],
            ]);
        }

        return view('app.event.index')->with([
            'calendar' => $calendar,
            'calendars' => $calendars,
            'title' => $title,
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

        $data = array_filter($request->only(Event::getFillableFields([], ['google_calendar_id', 'google_event_id'])), function ($value) {
            return ! is_null($value);
        });
        $oldGcId = $event->google_calendar_id;
        $newGcId = \Datamap::getCalendarByName($request->get('calendar', 'default'))['gcid'];
        if($oldGcId != $newGcId) {
            $event->deleteGoogleEvent();
            $event->google_calendar_id = $newGcId;
            $event->createGoogleEvent();
        }

        $event->update($data);

        return redirect()->route('app.get.event.show', $event->getKey());
    }

    public function getJoin(Request $request, Event $event)
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            if (! $event->isAttendee($user)) {
                $event->attendees()->attach($user->getKey());
                \Alert::success(trans('alerts.event_joined'))->flash();

                return redirect()->route('app.get.event.show', $event->getKey());
            }
        }

        \Alert::danger(trans('alerts.save_failed'))->flash();

        return redirect()->route('app.get.event.show', $event->getKey());
    }

    public function getLeave(Request $request, Event $event)
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            if ($event->isAttendee($user)) {
                $event->attendees()->detach($user->getKey());
                \Alert::success(trans('alerts.event_left'))->flash();

                return redirect()->route('app.get.event.show', $event->getKey());
            }
        }

        \Alert::danger(trans('alerts.save_failed'))->flash();

        return redirect()->route('app.get.event.show', $event->getKey());
    }
}
