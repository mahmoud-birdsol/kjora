<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamInvitationRequest;
use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\User;
use App\Services\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TeamInvitationController extends Controller
{
    /**
     * @param \App\Models\Team $team
     * @return \Inertia\Response
     */
    public function index(Team $team): Response
    {
        $users = User::whereNotIn('id', $team->players->pluck('id'));
        $teamInvitations = $team->teamInvitations()->with('invitedPlayer');
        return Inertia::render('TeamInvitations/Index', [
            'team' => $team,
            'teamInvitations' => $teamInvitations->paginate(),
            'users' => $users->paginate(10, '*', 'users_page')
        ]);
    }


    /**
     * @param \App\Http\Requests\TeamInvitationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TeamInvitationRequest $request): RedirectResponse
    {
        foreach ($request->players as $player) {
            TeamInvitation::create([
                'team_id' => $request->input('team_id'),
                'invited_player_id' => $player['id'],
                'state' => 'pending'
            ]);
        }

        FlashMessage::make()->success(
            message: 'Invitations Created Successfully'
        )->closeable()->send();


        return redirect()->back();
    }
}
