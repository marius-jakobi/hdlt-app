<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UploadPolicy
{
    use HandlesAuthorization;

    public function uploadShippingAddressFile(User $user) {
        return $user->hasPermission('upload-shipping-address-file');
    }

    public function viewShippingAddressUploads(User $user) {
        return $user->hasPermission('view-shipping-address-uploads');
    }
}
