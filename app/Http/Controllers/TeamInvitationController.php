<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamInvitationRequest;
use App\Http\Resources\SimpleUserResource;
use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\User;
use App\Services\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TeamInvitationController extends Controller
{
    /**
     * @param \App\Models\Team $team
     * @return \Inertia\Response
     */
    public function index(Team $team, Request $request)
    {
        $query = User::whereNotIn('id', $team->players->pluck('id'))
            ->orWhereNotIn('id', $team->teamInvitations->pluck('invited_player_id'));
        $request->whenFilled('search', function () use ($request, $query) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%");
            });
        });
        return SimpleUserResource::collection($query->paginate());
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
