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
        $invitations = Invitation::where('inviting_player_id', $request->user()->id)
            ->latest('date')
            ->with('invitedPlayer')
            ->with('stadium')
            ->get();

        return Inertia::render('Hire/Index', [
            'invitations' => $invitations,
        ]);
    }
}
