<?php

namespace App\Http\Controllers;

use App\Actions\CreateConversationAction;
use App\Models\Invitation;
use App\Notifications\GameScheduledNotification;
use App\Notifications\InvitationAcceptedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AcceptInvitationController extends Controller
{
    /**
     * Accept the user invitation
     */
    public function __invoke(
        Request $request,
        Invitation $invitation,
        CreateConversationAction $createConversationAction
    ): RedirectResponse {
        $invitation->forceFill(['state' => 'accepted'])->save();

        $createConversationAction($invitation);

        $invitation->invitingPlayer->notify(new InvitationAcceptedNotification($invitation));
        $invitation->invitedPlayer->notify(new GameScheduledNotification($invitation));

        return redirect()->route('invitation.index');
    }
}
