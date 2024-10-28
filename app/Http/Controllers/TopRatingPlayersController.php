<?php

namespace App\Http\Controllers;

use App\Http\Resources\SimpleUserResource;
use App\Models\User;
use Illuminate\Http\Request;

class TopRatingPlayersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $topRatingPlayers = User::query()->orderBy('rating', 'desc')->limit(5);
        return SimpleUserResource::collection($topRatingPlayers->get());
    }
}
