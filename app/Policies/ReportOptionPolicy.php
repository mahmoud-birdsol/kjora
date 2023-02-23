<?php

namespace App\Policies;

use App\Models\ReportOption;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportOptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Admin  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Admin $user): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('view report option');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\ReportOption  $reportOption
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $user, ReportOption $reportOption): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('view report option');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('create report option');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\ReportOption  $reportOption
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, ReportOption $reportOption): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('edit report option');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\ReportOption  $reportOption
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, ReportOption $reportOption): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete report option');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\ReportOption  $reportOption
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, ReportOption $reportOption): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete report option');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\ReportOption  $reportOption
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, ReportOption $reportOption): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete report option');
    }
}
