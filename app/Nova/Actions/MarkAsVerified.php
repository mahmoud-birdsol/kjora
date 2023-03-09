<?php

namespace App\Nova\Actions;

use App\Actions\Verification\VerifyUser;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class MarkAsVerified extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $action = resolve(VerifyUser::class);

        $models->each(fn (User $user) => $action($user));
    }
}
