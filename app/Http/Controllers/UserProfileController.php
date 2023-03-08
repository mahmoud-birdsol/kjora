<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\MediaLibrary;
use App\Models\Position;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
        /** @var \App\Models\User $user */
        $user = $request->user()->load('club');

        $ratingCategoriesCount = $request->user()->playerReviews->count();

        $playerRating = $request->user()->playerReviews->flatMap->ratingCategories->groupBy('name')
            ->map(function ($ratingCategory) use ($ratingCategoriesCount) {
                return [
                    'ratingCategory' => $ratingCategory->first()->name,
                    'value' => (double)$ratingCategory->sum('pivot.value') / $ratingCategoriesCount
                ];
            })->values();



        return Inertia::render('Profile/Show', [
            'user' => $user,
            'posts' => $user->posts->load('comments'),
            'playerRating' => $playerRating
        ]);
    }


    /**
     * Display and edit user profile page.
     *
     * @param \Illuminate\Http\Request $request
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
