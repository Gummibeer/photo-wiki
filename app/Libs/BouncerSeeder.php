<?php

namespace App\Libs;

use App\Models\Event;
use App\Models\User;
use Bouncer;

class BouncerSeeder
{
    public function seed()
    {
        Bouncer::allow('admin')->to('create', User::class);
        Bouncer::allow('admin')->to('edit', User::class);
        Bouncer::allow('admin')->to('delete', User::class);
        Bouncer::allow('user-mod')->to('edit', User::class);
        Bouncer::allow('user-admin')->to('create', User::class);
        Bouncer::allow('user-admin')->to('edit', User::class);
        Bouncer::allow('user-admin')->to('delete', User::class);

        Bouncer::allow('admin')->to('create', Event::class);
        Bouncer::allow('admin')->to('edit', Event::class);
        Bouncer::allow('admin')->to('delete', Event::class);
        Bouncer::allow('admin')->to('debug', Event::class);
        Bouncer::allow('event-mod')->to('create', Event::class);
        Bouncer::allow('event-mod')->to('edit', Event::class);
        Bouncer::allow('event-admin')->to('create', Event::class);
        Bouncer::allow('event-admin')->to('edit', Event::class);
        Bouncer::allow('event-admin')->to('delete', Event::class);
    }
}
