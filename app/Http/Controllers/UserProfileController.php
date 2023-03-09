<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\MediaLibrary;
use App\Models\Position;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserProfileController extends Controller
{
    /**
     * Display the user profile
     *
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
                    'value' => (float) $ratingCategory->sum('pivot.value') / $ratingCategoriesCount,
                ];
            })->values();

        $media = $user->getMedia('gallery')->map(function (MediaLibrary $media) {
            return [
                'id' => $media->id,
                'url' => $media->original_url,
                'type' => $media->type,
                'extension' => $media->extension,
                'comments' => $media->comments?->load('replies'),
            ];
        });

        return Inertia::render('Profile/Show', [
            'user' => $user,
            'media' => $media,
            'playerRating' => $playerRating,
        ]);
    }

    /**
     * Display and edit user profile page.
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
