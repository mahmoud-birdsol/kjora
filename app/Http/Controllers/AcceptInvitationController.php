<?php

namespace App\Http\Controllers;

use App\Actions\CreateConversationAction;
use App\Models\Invitation;
use App\Notifications\InvitationAcceptedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AcceptInvitationController extends Controller
{
    /**
     * Accept the user invitation
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Invitation $invitation
     * @param \App\Actions\CreateConversationAction $createConversationAction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(
        Request $request,
        Invitation $invitation,
        CreateConversationAction $createConversationAction
    ): RedirectResponse
    {
        $invitation->forceFill(['state' => 'accepted'])->save();

        $invitation->invitingPlayer->notify(new InvitationAcceptedNotification($invitation));

        $createConversationAction($invitation);

        return redirect()->route('invitation.index');
    }
}
