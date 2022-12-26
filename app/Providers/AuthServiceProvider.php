<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Admin;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Admin::class => \App\Policies\AdminPolicy::class,
        \App\Models\Advertisement::class => \App\Policies\AdvertisementPolicy::class,
        \App\Models\Click::class => \App\Policies\ClickPolicy::class,
        \App\Models\Club::class => \App\Policies\ClubPolicy::class,
        \App\Models\CookiePolicy::class => \App\Policies\CookiePolicyPolicy::class,
        \App\Models\Country::class => \App\Policies\CountryPolicy::class,
        \App\Models\Impression::class => \App\Policies\ImpressionPolicy::class,
        \App\Models\Position::class => \App\Policies\PositionPolicy::class,
        \App\Models\PrivacyPolicy::class => \App\Policies\PrivacyPolicyPolicy::class,
        \App\Models\RatingCategory::class => \App\Policies\RatingCategoryPolicy::class,
        \App\Models\Rating::class => \App\Policies\RatingPolicy::class,
        \Pktharindu\NovaPermissions\Role::class => \App\Policies\RolePolicy::class,
        \App\Models\TermsAndConditions::class => \App\Policies\TermsAndConditionsPolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        foreach (config('nova-permissions.permissions') as $key => $permissions) {
            Gate::define($key, function (Admin $user) use ($key) {
                if ($this->nobodyHasAccess($key)) {
                    return true;
                }

                return $user->hasPermissionTo($key);
            });
        }
    }
}
