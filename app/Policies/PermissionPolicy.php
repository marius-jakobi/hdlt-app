<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function create(User $user) {
        return false;
    }
    
    public function list(User $user) {
        return false;
    }

    public function view(User $user) {
        return false;
    }
    
    public function delete(User $user) {
        return false;
    }

    public function update(User $user, Permission $permission) {
        return false;
    }
}
