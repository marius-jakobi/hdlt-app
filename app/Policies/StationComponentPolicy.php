<?php

namespace App\Policies;

use App\Models\StationComponent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StationComponentPolicy
{
    use HandlesAuthorization;

    public function create(User $user) {
        if ($user->hasPermission('create-component')) {
            return true;
        }
    }

    public function view(User $user) {
        if ($user->hasPermission('view-component')) {
            return true;
        }
    }

    public function update(User $user) {
        if ($user->hasPermission('update-component')) {
            return true;
        }
    }
}
