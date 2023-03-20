<?php

namespace App\Actions;

use App\Models\Conversation;
use App\Models\User;
use Pusher\Pusher;

class CheckIfUserIsPresentAction
{
    /**
     * Check if user is present or not
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Pusher\ApiErrorException
     * @throws \Pusher\PusherException
     */
    public function __invoke(User $user, Conversation $conversation): bool
    {
        $userIsPresent = false;
        $connection = config('broadcasting.connections.pusher');
        $pusher = new Pusher(
            $connection['key'],
            $connection['secret'],
            $connection['app_id'],
            $connection['options'] ?? []
        );

        $channel = $pusher->getPresenceUsers('presence-chat.'.$conversation->id);

        foreach ($channel->users as $presentUser) {
            if ($presentUser->id == $user->id) {
                $userIsPresent = true;
            }
        }

        return $userIsPresent;
    }
}
