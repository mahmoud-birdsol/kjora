<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Label;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabelPolicy
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
        return $user->hasPermissionTo('view labels');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $user, Label $label)
    {
        return $user->hasPermissionTo('view labels');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user)
    {
        return $user->hasPermissionTo('create labels');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, Label $label)
    {
        return $user->hasPermissionTo('edit labels');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, Label $label)
    {
        return $user->hasPermissionTo('delete labels');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, Label $label)
    {
        return $user->hasPermissionTo('delete labels');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, Label $label)
    {
        return $user->hasPermissionTo('delete labels');
    }
}
