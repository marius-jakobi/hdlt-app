<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
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

    public function update(User $user, Role $role) {
        return false;
    }
}
