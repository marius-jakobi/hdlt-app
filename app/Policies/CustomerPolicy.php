<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function view(User $user) {
        return $user->hasPermission('view-customer');
    }

    public function update(User $user) {
        return $user->hasPermission('update-customer');
    }

    public function create(User $user) {
        return $user->hasPermission('create-customer');
    }
}
