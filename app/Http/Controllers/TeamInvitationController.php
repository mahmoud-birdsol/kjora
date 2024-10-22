<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamInvitationController extends Controller
{
    public function store(Request $request)
    {

        return back()->with('success', 'Team Invitation Sent Successfully');
    }
}
