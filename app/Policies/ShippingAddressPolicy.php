<?php

namespace App\Policies;

use App\ShippingAddress;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShippingAddressPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ShippingAddress $shippingAddress) {
        return true;
    }

    public function update(User $user, ShippingAddress $shippingAddress) {
        return false;
    }
}
