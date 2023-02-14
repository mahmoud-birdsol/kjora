<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PlayerController extends Controller
{
    /**
     * Display the home page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        $query = User::query();

        $request->whenFilled('position', fn() => $query->where('position_id', $request->input('position')));
        $request->whenFilled('rating',
            $request->input('rating') > 0
                ? fn() => $query->where(function ($query) use ($request) {
                $query->where('rating', '>=', $request->input('rating'));
            })
                : fn() => null
        );

        $request->whenFilled('age',
            fn() => $query->whereDate('date_of_birth', '<=', now()->subYears($request->input('age')))
        );

        $request->whenFilled('search', fn() => $query->where(function ($query) use ($request) {
            $query
                ->where('first_name', 'LIKE', '%'.$request->input('search').'%')
                ->orWhere('last_name', 'LIKE', '%'.$request->input('search').'%')
                ->orWhere('username', 'LIKE', '%'.$request->input('search').'%');
        }));

        return Inertia::render('Home', [
            'players' => $query->paginate(20),
            'positions' => Position::all(),
        ]);
    }

    /**
     * Display the player profile page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Inertia\Response
     */
    public function show(Request $request, User $user): Response
    {
        $user->load('club');

        return Inertia::render('Player/Show', [
            'player' => $user,
        ]);
    }
}
