<?php

namespace App\Policies;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function admin(User $user) {
        return $user->hasRole("administrator");
    }
}
