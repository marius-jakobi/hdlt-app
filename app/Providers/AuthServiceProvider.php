<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\User::class => \App\Policies\UserPolicy::class,
        \App\Role::class => \App\Policies\RolePolicy::class,
        \App\Permission::class => \App\Policies\PermissionPolicy::class,
        \App\Customer::class => \App\Policies\CustomerPolicy::class,
        \App\BillingAddress::class => \App\Policies\BillingAddressPolicy::class,
        \App\ShippingAddress::class => \App\Policies\ShippingAddressPolicy::class,
        \App\StationComponent::class => \App\Policies\StationComponentPolicy::class,
        \App\UploadFile::class => \App\Policies\UploadPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Bypass authorization for admins
        Gate::before(function (User $user) {
            if ($user->hasAdminRole()) {
                return true;
            }
        });
    }
}
