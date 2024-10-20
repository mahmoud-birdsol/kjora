<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SimpleUserResource;
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
        $query = User::query()->where('id', '!=', $request->user()->id);
        return UserNameResource::collection($query->get());
    }

    public function index(Request $request)
    {
        $query = User::query()->where('id', '!=', $request->user()->id);
        $request->whenFilled('search', function () use ($request, $query) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%");
            });
        });
        return SimpleUserResource::collection($query->get());
    }
}
