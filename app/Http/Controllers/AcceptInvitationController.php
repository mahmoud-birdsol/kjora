<?php

namespace App\Http\Controllers;

use App\Actions\CreateConversationAction;
use App\Models\Invitation;
use App\Notifications\GameScheduledNotification;
use App\Notifications\InvitationAcceptedNotification;
use App\Services\FlashMessage;
use Carbon\Carbon;
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
        if($invitation->state != 'cancelled') {
            $invitation->forceFill(['state' => 'accepted'])->save();

            $createConversationAction($invitation);

            $invitation->invitingPlayer->notify(new InvitationAcceptedNotification($invitation));
            $invitation->invitedPlayer->notify(new GameScheduledNotification($invitation));

            $this->changeStateOfSameDateInvitationsToCancelled($request->user()->invitations , $invitation);
            $this->changeStateOfSameDateInvitationsToCancelled($request->user()->hires , $invitation);

        }else{
            FlashMessage::make()->error(
                message: __('Sorry you cannot approve cancelled invitation')
            )->closeable()->send();
        }
        return redirect()->route('invitation.index');
    }
    private function changeStateOfSameDateInvitationsToCancelled( $invitations , $invitation){
        $querys = $invitations->where('state',null)->whereBetween('date', [Carbon::parse($invitation->date), Carbon::parse($invitation->date->addHours(2))]);

        foreach ($querys as $query){
            $query->state =  "cancelled";
            $query->save();
        }
    }
}
