<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalesProcessPolicy
{
    use HandlesAuthorization;

    public function view(User $user) {
        return $user->hasPermission('view-sales-processes');
    }
}
