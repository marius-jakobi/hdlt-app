<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceReportPolicy
{
    use HandlesAuthorization;

    public function list(User $user) {
        return $user->hasPermission('list-service-reports');
    }

    public function view(User $user) {
        return $user->hasPermission('view-service-report');
    }

    public function create(User $user) {
        return $user->hasPermission('create-service-report');
    }
}
