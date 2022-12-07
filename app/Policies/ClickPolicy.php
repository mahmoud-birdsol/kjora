<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Click;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClickPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Admin  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Admin $user)
    {
        return $user->hasPermissionTo('view clicks');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Click  $click
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $user, Click $click)
    {
        return $user->hasPermissionTo('view clicks');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user)
    {
        return $user->hasPermissionTo('create clicks');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Click  $click
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, Click $click)
    {
        return $user->hasPermissionTo('edit clicks');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Click  $click
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, Click $click)
    {
        return $user->hasPermissionTo('delete clicks');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Click  $click
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, Click $click)
    {
        return $user->hasPermissionTo('delete clicks');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Click  $click
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, Click $click)
    {
        return $user->hasPermissionTo('delete clicks');
    }
}
