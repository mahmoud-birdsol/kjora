<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InvitationController extends Controller
{
    /**
     * Display the invitations index page.
     */
    public function index(Request $request): Response
    {
        $query = Invitation::where('invited_player_id', $request->user()->id)
            ->whereNotNull('state')->where('date', '<', now()->addHours(2))
            ->latest('date')
            ->with('invitingPlayer')
            ->with(['reviews' => function ($q) use ($request) {
                $q->whereNot('player_id', '=', $request->user()->id)->whereDoesntHave('ratingCategories');
            }])
            ->with('stadium');


        $request->whenFilled('search', fn () => $query->where(function ($query) use ($request) {
            $query->whereHas('invitingPlayer', function ($q) use ($request) {
                $q->where('first_name', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('username', 'LIKE', '%' . $request->input('search') . '%');
            });
        }));

        $request->whenFilled(
            'dateFrom',
            fn () => $query->where('date', '>=', \Carbon\Carbon::parse($request->input('dateFrom'))->toDatetimeString())
        );
        $request->whenFilled(
            'dateTo',
            fn () => $query->where('date', '<=', \Carbon\Carbon::parse($request->input('dateTo'))->toDatetimeString())
        );
        return Inertia::render('Invitation/Index', [
            'invitations' => $query->get(),
        ]);
    }
}
