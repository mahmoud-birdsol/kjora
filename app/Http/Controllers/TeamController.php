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
            'myTeams' => $myTeams->paginate(),
            'teams' => $teams->paginate(),
            'topRatingPlayer' => SimpleUserResource::collection($topRatingPlayers->get())
        ]);
    }
    public function show($team)
    {
        $team = [
            'id' => 1,
            'name' => 'test',
            'image' => 'https://th.bing.com/th/id/OIP.rNCzUC11htsS4jErkJcZfgHaHa?rs=1&pid=ImgDetMain',
            'code' => '155',
            'users' => User::all(),
        ];
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



        if ($request->hasFile('team_logo')) {
            $team->addMediaFromRequest('team_logo')->toMediaCollection('team_logo');
        }
        $team = $team->update($data);

        FlashMessage::make()->success(
            message: 'Team Updated Successfully',
        )->closeable()->send();

        return redirect()->back();
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->back();
    }
}
