<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Services\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CancelInvitationController extends Controller
{
    /**
     * Cancel the user invitation.
     */
    public function __invoke(Request $request , Invitation $invitation): RedirectResponse
    {
        $invitation->forceFill(['state' => 'cancelled'])->save();
        FlashMessage::make()->success(
            message: __('Invitation Cancelled Successfully')
        )->closeable()->send();
        return redirect()->route('invitation.index');
    }
}
