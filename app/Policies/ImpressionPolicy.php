<?php

namespace App\Policies;

use App\Models\Impression;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImpressionPolicy
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
        return $user->hasPermissionTo('view impressions');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Impression  $impression
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $user, Impression $impression)
    {
        return $user->hasPermissionTo('view impressions');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user)
    {
        return $user->hasPermissionTo('create impressions');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Impression  $impression
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, Impression $impression)
    {
        return $user->hasPermissionTo('edit impressions');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Impression  $impression
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, Impression $impression)
    {
        return $user->hasPermissionTo('delete impressions');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Impression  $impression
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, Impression $impression)
    {
        return $user->hasPermissionTo('delete impressions');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Impression  $impression
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, Impression $impression)
    {
        return $user->hasPermissionTo('delete impressions');
    }
}
