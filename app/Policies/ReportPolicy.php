<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\Admin $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Admin $user): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('view report');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\Admin $user
     * @param \App\Models\Report $report
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $user, Report $report): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('view report');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\Admin $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('create report');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\Admin $user
     * @param \App\Models\Report $report
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, Report $report): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('edit report');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\Admin $user
     * @param \App\Models\Report $report
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, Report $report): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete report');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\Admin $user
     * @param \App\Models\Report $report
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, Report $report): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete report');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\Admin $user
     * @param \App\Models\Report $report
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, Report $report): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete report');
    }
}
