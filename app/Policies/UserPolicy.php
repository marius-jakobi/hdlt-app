<?php

namespace App\Policies;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function create(User $user) {
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                if ($permission->name === 'create-users') {
                    return true;
                }
            }
        }
    }
}
