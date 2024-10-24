<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamInvitation;
use App\Services\FlashMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcceptTeamInvitationController extends Controller
{
    public function create(Request $request, TeamInvitation $teamInvitation)
    {
        return Inertia::render('TeamInvitations/Accept', [
            'teamInvitation' => $teamInvitation
        ]);
    }

    public function store(Request $request, TeamInvitation $teamInvitation)
    {
        if ($teamInvitation->state != 'cancelled') {
            $teamInvitation->forceFill(['state' => 'accepted'])->save();
        }

        else {
            FlashMessage::make()->error(
                message: __('Sorry you cannot approve cancelled invitation')
            )->closeable()->send();
        }

        return redirect()->route('teams.invitations.index', $teamInvitation->team->id);
    }
}
