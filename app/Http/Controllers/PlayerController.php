<?php

namespace App\Http\Controllers;

use App\Jobs\CreateImpressionJob;
use App\Models\Advertisement;
use App\Models\Impression;
use App\Models\MediaLibrary;
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
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        $query = User::query()->whereNot('id', $request->user()->id);

        $request->whenFilled('position', fn () => $query->where('position_id', $request->input('position')));
        $request->whenFilled('rating',
            $request->input('rating') > 0
                ? fn () => $query->where(function ($query) use ($request) {
                    $query->where('rating', '>=', $request->input('rating'));
                })
                : fn () => null
        );

        $request->whenFilled('age',
            fn () => $query->whereDate('date_of_birth', '<=', now()->subYears($request->input('age')))
        );

        $request->whenFilled('country',
            fn () => $query->where('country_id', $request->input('country'))
        );

        $request->whenFilled('search', fn () => $query->where(function ($query) use ($request) {
            $query
                ->where('first_name', 'LIKE', '%' . $request->input('search') . '%')
                ->orWhere('last_name', 'LIKE', '%' . $request->input('search') . '%')
                ->orWhere('username', 'LIKE', '%' . $request->input('search') . '%');
        }));

        $advertisements = Advertisement::active()->orderBy('priority')
            ->with('media')
            ->get()
             ->each(function (Advertisement $advertisement) use ($request) {
                 CreateImpressionJob::dispatch($request->user(), $advertisement);
             });

        return Inertia::render('Home', [
            'players' => $query->paginate(20),
            'positions' => Position::all(),
            'advertisements' => Advertisement::orderBy('priority')->get()->map(function (Advertisement $advertisement) {
                return $advertisement->getFirstMediaUrl('main');
            }),
        ]);
    }

    /**
     * Display the player profile page.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Inertia\Response
     */
    public function show(Request $request, User $user): Response
    {
        $user->load('club');

        $media = $user->getMedia('gallery')->filter(function (MediaLibrary $mediaLibrary) {
            return $mediaLibrary->whereNull('suspended_at');
        })->map(function (MediaLibrary $media) {
            return [
                'id' => $media->id,
                'url' => $media->original_url,
                'type' => $media->type,
                'extension' => $media->extension,
                'comments' => $media->comments?->load('replies'),
            ];
        });

        $ratingCategoriesCount = $user->playerReviews->count();

        $playerRating = $user->playerReviews->flatMap->ratingCategories->groupBy('name')
            ->map(function ($ratingCategory) use ($ratingCategoriesCount) {
                return [
                    'ratingCategory' => $ratingCategory->first()->name,
                    'value' => (float) $ratingCategory->sum('pivot.value') / $ratingCategoriesCount,
                ];
            })->values();

        return Inertia::render('Player/Show', [
            'player' => $user,
            'media' => $media,
            'playerRating' => $playerRating,
        ]);
    }
}
