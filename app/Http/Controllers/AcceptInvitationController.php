<?php

namespace App\Http\Controllers;

use App\Actions\CreateConversationAction;
use App\Models\Invitation;
use App\Notifications\GameScheduledNotification;
use App\Notifications\InvitationAcceptedNotification;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\IcalendarGenerator\Components\Event;

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

        $invitation->invitingPlayer->notify(new InvitationAcceptedNotification($invitation));
        $invitation->invitedPlayer->notify(new GameScheduledNotification($invitation));

        $createConversationAction($invitation);

        return redirect()->route('invitation.index');
    }
}
