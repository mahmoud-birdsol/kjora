<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvitationResource;
use App\Models\Invitation;
use Illuminate\Http\Request;

class FetchInvitationController extends Controller
{
    /**
     * Return the invitation after the invitation created event
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Invitation $invitation
     * @return \App\Http\Resources\InvitationResource
     */
    public function __invoke(Request $request, Invitation $invitation)
    {
        return InvitationResource::make($invitation);
    }
}
