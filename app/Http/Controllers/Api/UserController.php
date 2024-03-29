<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserNameResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getUsersNames(Request $request)
    {
        $query = User::query()->where('id','!=' , $request->user()->id);
        return UserNameResource::collection($query->get());

    }
}
