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
        $invitations = Invitation::where('invited_player_id', $request->user()->id)
            ->latest('date')
            ->with('invitingPlayer')
            ->with('stadium')
            ->get();

        return Inertia::render('Invitation/Index', [
            'invitations' => $invitations,
        ]);
    }
}
