<?php
namespace App\Http\Controllers\App;


use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function getIndex()
    {
        $start = Carbon::yesterday('UTC')->startOfDay();
        $end = Carbon::now('UTC')->addYear()->endOfDay();

        $events = Event::byTimeFrame($start, $end)->get();

        dd($events->toArray());
    }
}