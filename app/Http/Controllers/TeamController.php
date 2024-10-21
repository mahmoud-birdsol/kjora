<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeamController extends Controller
{
    public function index()
    {
        $teams = [0 => [
            'id' => 1,
            'name' => 'test',
            'image' => 'https://th.bing.com/th/id/OIP.rNCzUC11htsS4jErkJcZfgHaHa?rs=1&pid=ImgDetMain',
            'code' => '155',
            'users' => User::all(),
        ]];
        return Inertia::render('teams/Index', [
            'teams' => $teams,
            'countries' => Country::paginate(),
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
        return Inertia::render('teams/Show', [
            'team' => $team,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|file',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'country_id' => 'required|numeric',
            'number' => 'required|numeric',
        ]);

        $team = array_merge($data, ['id' => 1]);
        return redirect()->back(302, [
            'team' => $team,
        ])->with('success', 'Team created successfully');
    }

    public function update($team)
    {
        return redirect()->back();
    }
    public function destroy($team)
    {
        return redirect()->back();
    }
}
