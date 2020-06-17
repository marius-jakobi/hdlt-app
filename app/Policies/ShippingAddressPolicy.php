<?php

namespace App\Policies;

use App\ShippingAddress;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShippingAddressPolicy
{
    use HandlesAuthorization;

    public function view(User $user) {
        if ($user->hasPermission('view-shipping-address')) {
            return true;
        }
    }

    public function create(User $user) {
        if ($user->hasPermission('create-shipping-address')) {
            return true;
        }
    }

    public function update(User $user) {
        if ($user->hasPermission('update-shipping-address')) {
            return true;
        }
    }
}
