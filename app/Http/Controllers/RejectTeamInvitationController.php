<?php

namespace App\Http\Controllers;

use App\Models\TeamInvitation;
use App\Services\FlashMessage;
use Illuminate\Http\Request;

class RejectTeamInvitationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, TeamInvitation $teamInvitation)
    {
        if ($teamInvitation->state != 'cancelled') {
            $teamInvitation->forceFill(['state' => 'rejected'])->save();
        } else {
            FlashMessage::make()->error(
                message: __('Sorry you cannot reject cancelled invitation')
            )->closeable()->send();
        }

        return redirect()->back();
    }
}
