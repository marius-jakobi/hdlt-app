<?php

namespace App\Policies;

use App\Customer;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function view(User $user) {
        return false;
    }

    public function list() {
        return false;
    }

    public function update(User $user, Customer $customer) {
        return false;
    }
}
