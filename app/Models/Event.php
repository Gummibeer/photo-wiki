<?php

namespace App\Models;

use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;
use MaddHatter\LaravelFullcalendar\IdentifiableEvent;
use Spatie\GoogleCalendar\Event as GoogleEvent;

class Event extends Model implements IdentifiableEvent
{
    use AlgoliaEloquentTrait;

    protected $table = 'events';

    protected $fillable = [
        'display_name',
        'starting_at',
        'ending_at',
        'timezone',
        'all_day',
        'address_street',
        'address_number',
        'address_zip',
        'address_city',
        'address_country',
        'address_country_code',
        'geoloc',
        'description',
        'google_calendar_id',
        'google_event_id',
    ];

    public $appends = [
        'address',
        'lat',
        'lng',
    ];

    protected $casts = [
        'geoloc' => 'array',
    ];

    protected $dates = [
        'starting_at',
        'ending_at',
    ];

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_attendees');
    }

    public function getId()
    {
        return $this->getKey();
    }

    public function getTitle()
    {
        return $this->display_name;
    }

    public function isAllDay()
    {
        return (bool) $this->all_day;
    }

    public function getStart()
    {
        return $this->starting_at;
    }

    public function getEnd()
    {
        return $this->ending_at;
    }

    public function address($glue = ', ')
    {
        $parts = [
            $this->address_street . ' ' . $this->address_number,
            $this->address_zip . ' ' . $this->address_city,
            $this->address_country,
        ];
        return implode($glue, array_filter($parts));
    }

    public function getAddressAttribute()
    {
        return $this->address();
    }

    public function getLatAttribute()
    {
        if(is_array($this->geoloc)) {
            return array_get($this->geoloc, 'lat');
        }
    }

    public function getLngAttribute()
    {
        if(is_array($this->geoloc)) {
            return array_get($this->geoloc, 'lng');
        }
    }

    public function startCarbon()
    {
        return $this->starting_at->setTimezoen($this->timezone);
    }

    public function endCarbon()
    {
        return $this->ending_at->setTimezoen($this->timezone);
    }

    public function hasGoogleEvent()
    {
        return (!empty($this->google_calendar_id) && !empty($this->google_event_id));
    }

    public function isGoogleEvent($event)
    {
        return (!empty($event) && is_object($event) && is_a($event, GoogleEvent::class));
    }

    public function getGoogleEvent()
    {
        if($this->hasGoogleEvent()) {
            return GoogleEvent::find($this->google_event_id, $this->google_calendar_id);
        }
    }

    public function createGoogleEvent()
    {
        $data = [];

        $data['name'] = $this->display_name;
        if($this->all_day) {
            $data['startDate'] = $this->startCarbon();
            $data['endDate'] = $this->endCarbon();
        } else {
            $data['startDateTime'] = $this->startCarbon();
            $data['endDateTime'] = $this->endCarbon();
        }
        if(!empty($this->address)) {
            $data['location'] = $this->address;
        }
        if(!empty($this->description)) {
            $data['description'] = $this->description;
        }

        $event = GoogleEvent::create($data, $this->google_calendar_id);
        $this->google_event_id = $event->id;
        return $event;
    }

    public function updateGoogleEvent()
    {
        $event = $this->googleEvent();

        if($this->isGoogleEvent($event)) {
            $event->name = $this->display_name;
            if ($this->all_day) {
                $event->startDate = $this->startCarbon();
                $event->endDate = $this->endCarbon();
            } else {
                $event->startDateTime = $this->startCarbon();
                $event->endDateTime = $this->endCarbon();
            }
            if (!empty($this->address)) {
                $event->location = $this->address;
            }
            if (!empty($this->description)) {
                $event->description = $this->description;
            }

            $event->save();
        }
    }

    public function deleteGoogleEvent()
    {
        $event = $this->googleEvent();

        if ($this->isGoogleEvent($event)) {
            $event->delete();
        }
    }
}
