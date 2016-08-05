<?php
namespace App\Http\Controllers;


use App\Models\Event;
use Carbon\Carbon;

class SiteMapController extends Controller
{
    public function getIndex()
    {
        $sitemap = \App::make('sitemap');

        if (!$sitemap->isCached())
        {
            // general
            $sitemap->add(url('/'), Carbon::now()->format('c'), '1.0', 'daily');
            $sitemap->add(url('/app'), Carbon::now()->format('c'), '1.0', 'daily');
            $sitemap->add(url('/auth'), Carbon::now()->format('c'), '1.0', 'daily');
            $sitemap->add(route('auth.get.login'), Carbon::now()->format('c'), '1.0', 'daily');
            $sitemap->add(route('auth.get.register'), Carbon::now()->format('c'), '1.0', 'daily');
            $sitemap->add(route('app.get.dashboard.show'), Carbon::now()->format('c'), '1.0', 'daily');

            // events
            $sitemap->add(route('app.get.event.index'), Carbon::now()->format('c'), '1.0', 'daily');
            $sitemap->add(route('app.get.event.create'), Carbon::now()->format('c'), '1.0', 'daily');
            foreach(Event::byApproved()->get() as $event) {
                $sitemap->add(route('app.get.event.show', $event->getKey()), $event->updated_at->format('c'), '1.0', 'daily');
            }

        }

        return $sitemap->render('xml');
    }
}