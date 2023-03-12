<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\CookiePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class CookiePolicyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Admin $user)
    {
        return $user->hasPermissionTo('view cookie policies');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $user, CookiePolicy $cookiePolicy)
    {
        return $user->hasPermissionTo('view cookie policies');
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user)
    {
        return $user->hasPermissionTo('create cookie policies');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, CookiePolicy $cookiePolicy)
    {
        return $user->hasPermissionTo('edit cookie policies');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, CookiePolicy $cookiePolicy)
    {
        return $user->hasPermissionTo('delete cookie policies');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, CookiePolicy $cookiePolicy)
    {
        return $user->hasPermissionTo('delete cookie policies');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, CookiePolicy $cookiePolicy)
    {
        return $user->hasPermissionTo('delete cookie policies');
    }
}
