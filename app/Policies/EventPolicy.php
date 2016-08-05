<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function manage(User $auth)
    {
        return $auth->can('delete', Event::class) || $auth->can('approve', Event::class);
    }
}
