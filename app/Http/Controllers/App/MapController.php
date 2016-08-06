<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Event;

class MapController extends Controller
{
    public function getIndex()
    {
        $events = Event::byApproved()->byRunningAt()->byGeoLoc('has')->get();

        return view('app.map.index')->with([
            'events' => $events,
        ]);
    }
}
