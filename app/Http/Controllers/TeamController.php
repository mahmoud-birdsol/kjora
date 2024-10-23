<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Http\Resources\SimpleUserResource;
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
        $myTeams = $request->user()->teams()->with(['players', 'country']);
        $team = Team::query();
        $teams = $team->where('owner_id', '!=', $request->user()->id)->with(['players']);
        $request->whenFilled('search', function () use ($teams, $myTeams, $request) {
            $teams->where('name', 'LIKE', '%' . $request->input('search') . '%');
            $myTeams->where('name', 'LIKE', '%' . $request->input('search') . '%');
        });
        $topRatingPlayers = User::query()->orderBy('rating', 'desc')->limit(5);
        return Inertia::render('teams/Index', [
            'myTeams' => $myTeams->paginate(12)->withQueryString(),
            'teams' => $teams->paginate(12)->withQueryString(),
            'topRatingPlayer' => SimpleUserResource::collection($topRatingPlayers->get())
        ]);
    }
    public function show(Team $team, Request $request)
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
        $players = $team->players();
        $request->whenFilled(
            'search',
            function () use ($players, $request) {
                $players->where('first_name', 'LIKE', '%' . $request->input('search') . '%');
                $players->where('last_name', 'LIKE', '%' . $request->input('search') . '%');
                $players->where('email', 'LIKE', '%' . $request->input('search') . '%');
            }
        );

        return Inertia::render('teams/Show', [
            'team' => $team,
            // team Players
            'players' => $players->get(),
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


    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->back();
    }
}
