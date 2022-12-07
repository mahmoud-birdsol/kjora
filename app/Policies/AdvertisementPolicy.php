<?php

namespace App\Policies;

use App\Models\Advertisement;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvertisementPolicy
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
        return $user->hasPermissionTo('view advertisements');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $user, Advertisement $advertisement)
    {
        return $user->hasPermissionTo('view advertisements');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $user)
    {
        return $user->hasPermissionTo('create advertisements');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $user, Advertisement $advertisement)
    {
        return $user->hasPermissionTo('edit advertisements');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $user, Advertisement $advertisement)
    {
        return $user->hasPermissionTo('delete advertisements');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $user, Advertisement $advertisement)
    {
        return $user->hasPermissionTo('delete advertisements');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $user, Advertisement $advertisement)
    {
        return $user->hasPermissionTo('delete advertisements');
    }
}
