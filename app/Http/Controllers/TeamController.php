<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Country;
use App\Models\Stadium;
use App\Models\Team;
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
    public function show(Team $team)
    {
        $matches = [
            '0' => [
                'team_1' => $team,
                'team_2' => $team,
                'point_team_1' => 3,
                'point_team_2' => 3,
                'stadium' => Stadium::first(),
            ]
        ];
        return Inertia::render('teams/Show', [
            'team' => $team,
            // team Players
            'players' => User::all(),
            // team Matches
            'matches' => fn() => $matches,
        ]);
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

    public function update(TeamRequest $request, Team $team)
    {
        $data = $request->validated();
        $team->update($data);

        if ($request->hasFile('team_logo')) {
            $team->addMediaFromRequest('team_logo')->toMediaCollection('team_logo');
        }

        FlashMessage::make()->success(
            message: 'Team updated Successfully',
        )->closeable()->send();

        return redirect()->back();
    }


    public function destroy($team)
    {
        return redirect()->back();
    }
}
