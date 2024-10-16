<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpgradeMembershipRequest;
use App\Models\States\Premium;
use App\Services\FlashMessage;
use Illuminate\Http\RedirectResponse;

class UpgradeMembershipController extends Controller
{
    /**
     * Upgrade the user membership
     */
    public function __invoke(UpgradeMembershipRequest $request): RedirectResponse
    {
        $request->user()->state->transitionTo(Premium::class);

        FlashMessage::make()->success(
            message: __('your-subscription-has-been-upgraded-to-premium')
        )->closeable()->send();

        return redirect()->route('home');
    }
}
