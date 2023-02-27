<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
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
        return $user->hasPermissionTo('view reviews');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\Admin $user
     * @param \App\Models\Review $review
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $user, Review $review): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('view reviews');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\Admin $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('create reviews');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\Admin $user
     * @param \App\Models\Review $review
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, Review $review): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('edit reviews');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\Admin $user
     * @param \App\Models\Review $review
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, Review $review): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete reviews');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\Admin $user
     * @param \App\Models\Review $review
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, Review $review): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete reviews');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\Admin $user
     * @param \App\Models\Review $review
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, Review $review): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete reviews');
    }
}
