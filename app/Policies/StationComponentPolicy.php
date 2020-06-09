<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StationComponentPolicy
{
    use HandlesAuthorization;

    public function create(User $user) {
        if ($user->hasPermission('create-component')) {
            return true;
        }
    }
}
