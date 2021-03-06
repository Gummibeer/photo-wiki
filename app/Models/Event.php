<?php

namespace App\Models;

use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
        'location',
        'geoloc',
        'description',
        'google_calendar_id',
        'google_event_id',
        'approved',
    ];

    public $appends = [
        'lat',
        'lng',
        'calendar',
    ];

    protected $casts = [
        'geoloc' => 'array',
    ];

    protected $defaultValues = [
        'timezone' => 'Europe/Berlin',
    ];

    public $algoliaSettings = [
        'attributesToIndex' => [
            'id',
            'display_name',
            'calendar_name',
            'location',
            'description',
            '_geoloc',
        ],
        'customRanking' => [
        ],
    ];

    public function getAlgoliaRecord()
    {
        return [
            'id' => $this->getKey(),
            'display_name' => $this->display_name,
            'calendar_name' => $this->calendar['display_name'],
            'location' => $this->location,
            'description' => $this->description,
            'starting_at' => $this->starting_at,
            'ending_at' => $this->ending_at,
            '_geoloc' => $this->geoloc,
        ];
    }

    public function indexOnly($index_name)
    {
        return (bool) ($this->approved && $this->ending_at->isFuture());
    }

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

    public function getLatAttribute()
    {
        if (is_array($this->geoloc)) {
            return array_get($this->geoloc, 'lat');
        }
    }

    public function getLngAttribute()
    {
        if (is_array($this->geoloc)) {
            return array_get($this->geoloc, 'lng');
        }
    }

    public function getCalendarAttribute()
    {
        return \Datamap::getCalendarById($this->google_calendar_id);
    }

    public function getStartingAtAttribute($value)
    {
        if (! empty($value)) {
            return $this->asDateTime($value)
                ->setTimezone($this->timezone);
        }
    }

    public function setStartingAtAttribute($value)
    {
        if (is_string($value)) {
            $carbon = Carbon::createFromFormat(trans('helpers.datetimeformat.php'), $value, $this->timezone);
        } elseif ($value instanceof Carbon) {
            $carbon = $value;
        } else {
            $carbon = $this->asDateTime($this->getOriginal('starting_at', Carbon::now()));
        }
        $this->attributes['starting_at'] = $carbon->setTimezone('UTC');
    }

    public function getEndingAtAttribute($value)
    {
        if (! empty($value)) {
            return $this->asDateTime($value)
                ->setTimezone($this->timezone);
        }
    }

    public function setEndingAtAttribute($value)
    {
        if (is_string($value)) {
            $carbon = Carbon::createFromFormat(trans('helpers.datetimeformat.php'), $value, $this->timezone);
        } elseif ($value instanceof Carbon) {
            $carbon = $value;
        } else {
            $carbon = $this->asDateTime($this->getOriginal('ending_at', Carbon::now()->addHour()));
        }
        $this->attributes['ending_at'] = $carbon->setTimezone('UTC');
    }

    public function setLocationAttribute($value)
    {
        $this->attributes['location'] = $value;
        if (! empty($value)) {
            $this->attributes['geoloc'] = json_encode(\Helper::getGeolocByAddress($value));
        } else {
            $this->attributes['geoloc'] = '';
        }
    }

    public function hasGoogleEvent()
    {
        return ! empty($this->google_calendar_id) && ! empty($this->google_event_id);
    }

    public function isGoogleEvent($event)
    {
        return ! empty($event) && is_object($event) && is_a($event, GoogleEvent::class);
    }

    public function getGoogleEvent()
    {
        if ($this->hasGoogleEvent()) {
            try {
                return GoogleEvent::find($this->google_event_id, $this->google_calendar_id);
            } catch (\Exception $e) {
                \Log::warning($e);
            }
        }
    }

    public function createGoogleEvent()
    {
        if ($this->hasGoogleEvent()) {
            return $this->updateGoogleEvent();
        }
        $data = [];
        $data['name'] = $this->display_name;
        if ($this->all_day) {
            $data['startDate'] = $this->starting_at;
            $data['endDate'] = $this->ending_at;
        } else {
            $data['startDateTime'] = $this->starting_at;
            $data['endDateTime'] = $this->ending_at;
        }
        if (! empty($this->location)) {
            $data['location'] = $this->location;
        }
        if (! empty($this->description)) {
            $data['description'] = $this->description;
        }
        $data['anyoneCanAddSelf'] = true;
        $data['visibility'] = 'public';
        $data['transparency'] = 'transparent';

        $event = GoogleEvent::create($data, $this->google_calendar_id);
        $this->google_event_id = $event->id;

        return $event;
    }

    public function updateGoogleEvent()
    {
        $event = $this->getGoogleEvent();

        if ($this->isGoogleEvent($event)) {
            $event->name = $this->display_name;
            if ($this->all_day) {
                $event->startDate = $this->starting_at;
                $event->endDate = $this->ending_at;
            } else {
                $event->startDateTime = $this->starting_at;
                $event->endDateTime = $this->ending_at;
            }
            if (! empty($this->location)) {
                $event->location = $this->location;
            }
            if (! empty($this->description)) {
                $event->description = $this->description;
            }

            $event->save();

            return $event;
        }
    }

    public function deleteGoogleEvent()
    {
        $event = $this->getGoogleEvent();

        if ($this->isGoogleEvent($event)) {
            try {
                $event->delete();
                $this->update([
                    'google_calendar_id' => null,
                    'google_event_id' => null,
                ]);
            } catch (\Exception $e) {
                \Log::warning($e);
            }
        }
    }

    public static function importGoogleEvent(Event $event, $gcid, GoogleEvent $gEvent)
    {
        if ($event->isGoogleEvent($gEvent)) {
            $event->display_name = $gEvent->name;
            $event->all_day = $gEvent->isAllDayEvent();
            $timezone = $gEvent->start->getTimeZone();
            if (empty($timezone)) {
                $timezone = $gEvent->end->getTimeZone();
            }
            if (! empty($timezone)) {
                $event->timezone = $gEvent->start->getTimeZone();
            }
            if ($event->all_day) {
                $event->starting_at = $gEvent->startDate;
                $event->ending_at = $gEvent->endDate;
            } else {
                $event->starting_at = $gEvent->startDateTime;
                $event->ending_at = $gEvent->endDateTime;
            }
            $location = $gEvent->location;
            if (! empty($location)) {
                $event->location = $location;
            }
            $description = $gEvent->description;
            if (! empty($description)) {
                $event->description = $description;
            }
            $event->google_event_id = $gEvent->id;
            $event->google_calendar_id = $gcid;
            $event->approved = true;

            return (bool) $event->save();
        }

        return false;
    }

    public function reloadGoogleEvent()
    {
        if ($this->hasGoogleEvent()) {
            return self::importGoogleEvent($this, $this->google_calendar_id, $this->getGoogleEvent());
        }

        return false;
    }

    public function approve()
    {
        $startingAt = $this->starting_at;
        $endingAt = $this->ending_at;
        $this->createGoogleEvent();
        $this->approved = true;
        $this->save();
        $event = self::find($this->getKey());
        $event->update([
            'starting_at' => $startingAt,
            'ending_at' => $endingAt,
        ]);
    }

    public function delete()
    {
        $this->deleteGoogleEvent();

        return parent::delete();
    }

    public function scopeByGcId(Builder $query, $gcid)
    {
        $query->where('google_calendar_id', $gcid);
    }

    public function scopeByGcName(Builder $query, $name)
    {
        $gcid = \Datamap::getCalendarByName($name)['gcid'];
        $query->byGcId($gcid);
    }

    public function scopeByGeId(Builder $query, $geid)
    {
        $query->where('google_event_id', $geid);
    }

    public function scopeByStart(Builder $query, Carbon $date = null)
    {
        if (is_null($date)) {
            $date = Carbon::yesterday('UTC')->startOfMonth();
        }
        $date = $date->setTimezone('UTC');
        $query->where(function ($query) use ($date) {
            $query->where('starting_at', '>=', $date)
                ->orWhere(function ($query) use ($date) {
                    $query
                        ->where('starting_at', '<=', $date)
                        ->where('ending_at', '>=', $date);
                });
        });
    }

    public function scopeByEnd(Builder $query, Carbon $date = null)
    {
        if (is_null($date)) {
            $date = Carbon::now('UTC')->addYear()->endOfDay();
        }
        $query->where('ending_at', '<=', $date);
    }

    public function scopeByTimeFrame(Builder $query, Carbon $start = null, Carbon $end = null)
    {
        $query->byStart($start)->byEnd($end);
    }

    public function scopeByUpcoming(Builder $query)
    {
        $end = Carbon::now('UTC')->startOfDay();
        $query
            ->where('ending_at', '>=', $end);
    }

    public function scopeByRunningAt(Builder $query, Carbon $day = null)
    {
        if (is_null($day)) {
            $day = Carbon::now('UTC');
        }
        $start = $day->copy()->endOfDay();
        $end = $day->copy()->startOfDay();
        $query
            ->where('starting_at', '<=', $start)
            ->where('ending_at', '>=', $end);
    }

    public function scopeByApproved(Builder $query, $approved = true)
    {
        $query->where('approved', $approved);
    }

    public function scopeByName(Builder $query, $name)
    {
        $query->where('display_name', $name);
    }

    public function scopeByGeoLoc(Builder $query, $geoloc)
    {
        if ($geoloc == 'has') {
            $query->where('geoloc', '<>', '')->whereNotNull('geoloc');
        } elseif (is_array($geoloc) && array_key_exists('lat', $geoloc) && array_key_exists('lng', $geoloc)) {
            $query->where('geoloc', json_encode(['lat' => $geoloc['lat'], 'lng' => $geoloc['lng']]));
        }
    }

    public static function checkForExistence(Event $event)
    {
        return self::query()
            ->byGcId($event->google_calendar_id)
            ->byName($event->display_name)
            ->byTimeFrame($event->starting_at, $event->ending_at)
            ->exists();
    }

    public function isAttendee($user)
    {
        $userId = $user;
        if ($user instanceof User) {
            $userId = $user->getKey();
        }

        return $this->attendees()->where('id', $userId)->exists();
    }
}
