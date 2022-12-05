<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Pktharindu\NovaPermissions\Role;

class RolePolicy
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
        return $user->hasPermissionTo('view roles');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \Pktharindu\NovaPermissions\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $user, Role $role)
    {
        return $user->hasPermissionTo('view roles');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user)
    {
        return $user->hasPermissionTo('create roles');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \Pktharindu\NovaPermissions\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, Role $role)
    {
        return $user->hasPermissionTo('edit roles');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \Pktharindu\NovaPermissions\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, Role $role)
    {
        return $user->hasPermissionTo('delete roles');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \Pktharindu\NovaPermissions\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, Role $role)
    {
        return $user->hasPermissionTo('delete roles');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \Pktharindu\NovaPermissions\Role  $role
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, Role $role)
    {
        return $user->hasPermissionTo('delete roles');
    }
}
