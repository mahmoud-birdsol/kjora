<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\RatingCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatingCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Admin $user)
    {
        return $user->hasPermissionTo('view rating categories');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $user, RatingCategory $ratingCategory)
    {
        return $user->hasPermissionTo('view rating categories');
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user)
    {
        return $user->hasPermissionTo('create rating categories');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, RatingCategory $ratingCategory)
    {
        return $user->hasPermissionTo('edit rating categories');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, RatingCategory $ratingCategory)
    {
        return $user->hasPermissionTo('delete rating categories');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, RatingCategory $ratingCategory)
    {
        return $user->hasPermissionTo('delete rating categories');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, RatingCategory $ratingCategory)
    {
        return $user->hasPermissionTo('delete rating categories');
    }
}
