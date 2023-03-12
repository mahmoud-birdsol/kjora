<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
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
        return $user->hasPermissionTo('view contacts');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Contact  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $user, Contact $model)
    {
        return $user->hasPermissionTo('view contacts');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user)
    {
        return $user->hasPermissionTo('create contacts');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Contact  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, Contact $model)
    {
        return $user->hasPermissionTo('edit contacts');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Contact  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, Contact $model)
    {
        return $user->hasPermissionTo('delete contacts');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Contact  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, Contact $model)
    {
        return $user->hasPermissionTo('delete contacts');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Contact  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, Contact $model)
    {
        return $user->hasPermissionTo('delete contacts');
    }
}
