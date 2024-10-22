<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Country;
use App\Models\User;
use App\Services\FlashMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeamController extends Controller
{
    public function index(Request $request): \Inertia\Response
    {
        $teams = $request->user()->teams()->with('players');

        return Inertia::render('teams/Index', [
            'teams' => $teams->paginate(),
            'countries' => Country::all()
        ]);
    }
    public function create()
    {
        return redirect()->back();
    }

    public function store(TeamRequest $request)
    {
        $data = $request->validated();
        $data['owner_id'] = $request->user()->id;

        $team = $request->user()->teams()->create($data);


        if ($request->hasFile('team_logo')) {
            $team->addMediaFromRequest('team_logo')->toMediaCollection('team_logo');
        }

        FlashMessage::make()->success(
            message: 'Team Created Successfully',
        )->closeable()->send();


        return redirect()->back();
    }
    public function show($team)
    {
        return Inertia::render('teams/show', [
            'team' => $team,
        ]);
    }
}
