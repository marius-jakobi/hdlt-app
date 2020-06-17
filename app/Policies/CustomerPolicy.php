<?php

namespace App\Policies;

use App\Customer;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function view(User $user) {
        if ($user->hasPermission('view-customer')) {
            return true;
        }
    }

    public function list() {
        return false;
    }

    public function update(User $user) {
        if ($user->hasPermission('update-customer')) {
            return true;
        }
    }
}
