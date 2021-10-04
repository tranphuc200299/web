<?php

namespace Modules\Tenant\Providers\Tenant;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Modules\Auth\Entities\Models\User;
use Modules\Tenant\Entities\Models\TenantModel;
use Modules\Tenant\Policies\TenantPolicy;

class PolicyServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        TenantModel::class => TenantPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function (User $user) {
            if ($user->roles->pluck('name')->contains('super-admin')) {
                //admin always pass;
                return true;
            }
        });
    }
}
