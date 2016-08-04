<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getShow()
    {
        Event::setSettings();

        $events = Event::byApproved()->byStart(Carbon::now()->startOfDay())->orderBy('starting_at', 'asc')->limit(5)->get();

        return view('app.dashboard.show')->with([
            'events' => $events,
        ]);
    }
}
