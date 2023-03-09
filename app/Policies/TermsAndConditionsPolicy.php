<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\TermsAndConditions;
use Illuminate\Auth\Access\HandlesAuthorization;

class TermsAndConditionsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Admin $user)
    {
        return $user->hasPermissionTo('view terms and conditions');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $user, TermsAndConditions $termsAndConditions)
    {
        return $user->hasPermissionTo('view terms and conditions');
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user)
    {
        return $user->hasPermissionTo('create terms and conditions');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, TermsAndConditions $termsAndConditions)
    {
        return $user->hasPermissionTo('edit terms and conditions');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, TermsAndConditions $termsAndConditions)
    {
        return $user->hasPermissionTo('delete terms and conditions');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, TermsAndConditions $termsAndConditions)
    {
        return $user->hasPermissionTo('delete terms and conditions');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, TermsAndConditions $termsAndConditions)
    {
        return $user->hasPermissionTo('delete terms and conditions');
    }
}
