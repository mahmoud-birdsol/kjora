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
     */
    public function viewAny(Admin $user): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('view reviews');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $user, Review $review): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('view reviews');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $user): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('create reviews');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $user, Review $review): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('edit reviews');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $user, Review $review): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete reviews');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $user, Review $review): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete reviews');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $user, Review $review): \Illuminate\Auth\Access\Response|bool
    {
        return $user->hasPermissionTo('delete reviews');
    }
}
