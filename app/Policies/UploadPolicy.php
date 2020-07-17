<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UploadPolicy
{
    use HandlesAuthorization;

    public function upload(User $user) {
        return $user->hasPermission('upload-files');
    }

    public function view(User $user) {
        return $user->hasPermission('view-uploads');
    }
}
