<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('users.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('users.chat.{id}', function ($user, $id) {
    return $user->conversations()->where('conversations.id', $id)->count();
});

Broadcast::channel('presence-chat.{id}', function ($user, $id) {
    return $user->conversations()->where('conversations.id', $id)->count();
});

Broadcast::channel('users.comment.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

//Broadcast::channel('chat', function ($user) {
//    if (auth()->check()) {
//        return $user->toArray();
//    }
//});

Broadcast::channel('chat.{id}', function ($user, $id) {
    if (auth()->check()) {
        return $user->toArray();
    }
});
