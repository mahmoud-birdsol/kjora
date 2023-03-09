<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Report;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $user): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('view report');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $user, Report $report): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('view report');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $user): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('create report');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $user, Report $report): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('edit report');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $user, Report $report): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete report');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $user, Report $report): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete report');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $user, Report $report): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete report');
    }
}
