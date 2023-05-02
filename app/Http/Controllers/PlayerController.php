<?php

namespace App\Http\Controllers;

use App\Jobs\CreateImpressionJob;
use App\Models\Advertisement;
use App\Models\Country;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PlayerController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(Request $request): Response
    {
        $query = User::query()->select(DB::raw("*,
                     (3959 * ACOS(COS(RADIANS({$request->user()->current_latitude}))
                           * COS(RADIANS(current_latitude))
                           * COS(RADIANS({$request->user()->current_longitude}) - RADIANS(current_longitude))
                           + SIN(RADIANS({$request->user()->current_latitude}))
                           * SIN(RADIANS(current_latitude)))) AS distance"))->orderBy('distance','asc');

        $request->whenFilled('position', fn () => $query->where('position_id', $request->input('position')));
        $request->whenFilled('ratingFrom', fn () => $query->where(function ($query) use ($request) {
            $query->where('rating', '>=', $request->input('ratingFrom'));
        })
        );
        $request->whenFilled('ratingTo', fn () => $query->where(function ($query) use ($request) {
            $query->where('rating', '<=', $request->input('ratingTo'));
        })
        );

        $request->whenFilled('ageFrom',
            fn () => $query->whereDate('date_of_birth', '<=', now()->subYears($request->input('ageFrom')))
        );

        $request->whenFilled('ageTo',
            fn () => $query->whereDate('date_of_birth', '>=', now()->subYears($request->input('ageTo')))
        );

        $request->whenFilled('country_id',
            fn () => $query->where('country_id', $request->input('country_id'))
        );

        $request->whenFilled('search', fn () => $query->where(function ($query) use ($request) {
            $query
                ->where('first_name', 'LIKE', '%'.$request->input('search').'%')
                ->orWhere('last_name', 'LIKE', '%'.$request->input('search').'%')
                ->orWhere('username', 'LIKE', '%'.$request->input('search').'%');
        }));

        $request->whenFilled('location', fn () => $query->having('distance', '<', $request->input('location'))
            ->select(DB::raw("*,
                     (3959 * ACOS(COS(RADIANS({$request->user()->current_latitude}))
                           * COS(RADIANS(current_latitude))
                           * COS(RADIANS({$request->user()->current_longitude}) - RADIANS(current_longitude))
                           + SIN(RADIANS({$request->user()->current_latitude}))
                           * SIN(RADIANS(current_latitude)))) AS distance")
            ));

        $advertisements = Advertisement::active()->orderBy('priority')
            ->with('media')
            ->get()
            ->each(function (Advertisement $advertisement) use ($request) {
                CreateImpressionJob::dispatch($request->user(), $advertisement);
            });

        return Inertia::render('Home', [
            'players' => $query->paginate(9),
            'positions' => Position::all(),
            'countries' => Country::active()->orderBy('name')->get(),
            'advertisements' => $advertisements,
        ]);
    }

    /**
     * Display the player profile page.
     */
    public function show(Request $request, User $user): Response
    {
        $user->load('club');

        $ratingCategoriesCount = $user->playerReviews->count();

        $playerRating = $user->playerReviews->flatMap->ratingCategories->groupBy('name')
            ->map(function ($ratingCategory) use ($ratingCategoriesCount) {
                return [
                    'ratingCategory' => $ratingCategory->first()->name,
                    'value' => (float) $ratingCategory->sum('pivot.value') / $ratingCategoriesCount,
                ];
            })->values();

        $countries = Country::active()->orderBy('name')->get();
        $positions = Position::all();

        return Inertia::render('Player/Show', [
            'player' => $user,
            'posts' => $user->posts->load('comments'),
            'playerRating' => $playerRating,
            'countries' => $countries,
            'positions' => $positions,
        ]);
    }
}
