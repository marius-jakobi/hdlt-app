<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Role::class => \App\Policies\RolePolicy::class,
        \App\Models\Permission::class => \App\Policies\PermissionPolicy::class,
        \App\Models\Customer::class => \App\Policies\CustomerPolicy::class,
        \App\Models\BillingAddress::class => \App\Policies\BillingAddressPolicy::class,
        \App\Models\ShippingAddress::class => \App\Policies\ShippingAddressPolicy::class,
        \App\Models\StationComponent::class => \App\Policies\StationComponentPolicy::class,
        \App\Models\UploadFile::class => \App\Policies\UploadPolicy::class,
        \App\Models\SalesProcess::class => \App\Policies\SalesProcessPolicy::class
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
