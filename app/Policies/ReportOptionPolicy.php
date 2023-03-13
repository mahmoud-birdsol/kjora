<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\ReportOption;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportOptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $user): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('view report option');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $user, ReportOption $reportOption): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('view report option');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $user): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('create report option');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $user, ReportOption $reportOption): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('edit report option');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $user, ReportOption $reportOption): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete report option');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $user, ReportOption $reportOption): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete report option');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $user, ReportOption $reportOption): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete report option');
    }
}
