<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\PrivacyPolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrivacyPolicyPolicy
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
        return $user->hasPermissionTo('view privacy policies');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $user, PrivacyPolicy $privacyPolicy)
    {
        return $user->hasPermissionTo('view privacy policies');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user)
    {
        return $user->hasPermissionTo('create privacy policies');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, PrivacyPolicy $privacyPolicy)
    {
        return $user->hasPermissionTo('edit privacy policies');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, PrivacyPolicy $privacyPolicy)
    {
        return $user->hasPermissionTo('delete privacy policies');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, PrivacyPolicy $privacyPolicy)
    {
        return $user->hasPermissionTo('delete privacy policies');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\PrivacyPolicy  $privacyPolicy
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, PrivacyPolicy $privacyPolicy)
    {
        return $user->hasPermissionTo('delete privacy policies');
    }
}
