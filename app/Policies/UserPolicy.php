<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function manage(User $auth)
    {
        return ($auth->can('create', User::class) || $auth->can('edit', User::class) || $auth->can('delete', User::class));
    }
}
