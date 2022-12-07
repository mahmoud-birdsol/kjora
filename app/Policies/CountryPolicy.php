<?php

namespace App\Policies;

use App\Models\Country;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
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
        return $user->hasPermissionTo('view countries');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $user, Country $country)
    {
        return $user->hasPermissionTo('view countries');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user)
    {
        return $user->hasPermissionTo('create countries');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, Country $country)
    {
        return $user->hasPermissionTo('edit countries');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, Country $country)
    {
        return $user->hasPermissionTo('delete countries');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, Country $country)
    {
        return $user->hasPermissionTo('delete countries');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, Country $country)
    {
        return $user->hasPermissionTo('delete countries');
    }
}
