<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user, User $model) {
        // A user can only view his own profile
        return $user->id === $model->id;
    }
    
    public function list(User $user) {
        // No user can list users
        return false;
    }

    public function update(User $user, User $model) {
        // User can only update himself
        return $user->id === $model->id;
    }

    public function delete(User $user, User $model) {
        // No one can delete himself
        return false;
    }

    public function create(User $user) {
        // No one can create users
        return false;
    }

    public function changePassword(User $user, User $model) {
        return ($user->id === $model->id) && $user->hasPermission('change-password');
    }
}
