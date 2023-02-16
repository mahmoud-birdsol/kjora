<?php

namespace App\Policies;

use App\Models\Social;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class SocialPolicy
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
        return $user->hasPermissionTo('view socials');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Social  $social
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $user, Social $social)
    {
        return $user->hasPermissionTo('view socials');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user)
    {
        return $user->hasPermissionTo('create socials');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Social  $social
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, Social $social)
    {
        return $user->hasPermissionTo('edit socials');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Social  $social
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, Social $social)
    {
        return $user->hasPermissionTo('delete socials');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Social  $social
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, Social $social)
    {
        return $user->hasPermissionTo('delete socials');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Social  $social
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, Social $social)
    {
        return $user->hasPermissionTo('delete socials');
    }
}
