<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Position;
use App\Models\User;
use App\Services\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()->favorites();

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

        $request->whenFilled('country_id',
            fn() => $query->where('country_id', $request->input('country_id'))
        );

        $request->whenFilled('search', fn() => $query->where(function ($query) use ($request) {
            $query
                ->where('first_name', 'LIKE', '%' . $request->input('search') . '%')
                ->orWhere('last_name', 'LIKE', '%' . $request->input('search') . '%')
                ->orWhere('username', 'LIKE', '%' . $request->input('search') . '%');
        }));

        $request->whenFilled('location', fn() => $query->having('distance', '<', $request->input('location'))
            ->select(DB::raw("
                     (3959 * ACOS(COS(RADIANS({$request->user()->current_latitude}))
                           * COS(RADIANS(current_latitude))
                           * COS(RADIANS({$request->user()->current_longitude}) - RADIANS(current_longitude))
                           + SIN(RADIANS({$request->user()->current_latitude}))
                           * SIN(RADIANS(current_latitude)))) AS distance")
            ));


        return Inertia::render('Favorites/Index', [
            'players' => $query->paginate(20),
            'positions' => Position::all(),
            'countries' => Country::active()->orderBy('name')->get()
        ]);
    }

    /**
     * Store the new favorite.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $favorite
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(
        Request $request,
        User    $favorite
    ): RedirectResponse
    {
        $request->user()->favorites()->attach($favorite);

        FlashMessage::make()->success(
            message: $favorite->name . ' has been successfully added to your favorites.'
        )->closeable()->send();

        return redirect()->back();
    }

    /**
     * Remove the specified favorite.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $favorite
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(
        Request $request,
        User    $favorite
    ): RedirectResponse
    {
        $request->user()->favorites()->detach($favorite);

        FlashMessage::make()->success(
            message: $favorite->name . ' has been successfully removed from your favorites.'
        )->closeable()->send();

        return redirect()->back();
    }
}
