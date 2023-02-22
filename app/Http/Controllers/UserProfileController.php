<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Position;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserProfileController extends Controller
{
    /**
     * Display the user profile
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function show(Request $request)
    {
        $user = $request->user()->load('club');

        return Inertia::render('Profile/Show', [
            'user' => $user
        ]);
    }


    /**
     * Display and edit user profile page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function edit(Request $request): Response
    {
        $user = $request->user()->load('club');
        $countries = Country::active()->orderBy('name')->get();
        $positions = Position::all();

        return Inertia::render('Profile/Edit', [
            'user' => $user,
            'countries' => $countries,
            'positions' => $positions,
        ]);
    }
}
