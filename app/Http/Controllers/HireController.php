<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HireController extends Controller
{
    /**
     * Display the invitations index page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        $query = Invitation::where('inviting_player_id', $request->user()->id)
            ->latest('date')
            ->with('invitedPlayer')
            ->with('stadium');

        $request->whenFilled('dateFrom',
            fn() => $query->where('date', '>=', \Carbon\Carbon::parse($request->input('dateFrom'))->toDatetimeString())
        );
        $request->whenFilled('dateTo',
            fn() => $query->where('date', '<=', \Carbon\Carbon::parse($request->input('dateTo'))->toDatetimeString() )
        );


        return Inertia::render('Hire/Index', [
            'invitations' => $query->get(),
        ]);
    }
}
