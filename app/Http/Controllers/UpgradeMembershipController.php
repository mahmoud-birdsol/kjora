<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpgradeMembershipRequest;
use App\Models\States\Premium;
use App\Services\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UpgradeMembershipController extends Controller
{
    /**
     * Upgrade the user membership
     *
     * @param \App\Http\Requests\UpgradeMembershipRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(UpgradeMembershipRequest $request): RedirectResponse
    {
        $request->user()->state->transitionTo(Premium::class);

        FlashMessage::make()->success(
            message: 'Your Subscription has been upgraded to Premium'
        )->closeable()->send();

        return redirect()->route('home');
    }
}
