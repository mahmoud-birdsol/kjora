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
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'users' => User::all(),
            'image' => 'https://th.bing.com/th/id/OIP.rNCzUC11htsS4jErkJcZfgHaHa?rs=1&pid=ImgDetMain'
        ]];
        return Inertia::render('teams/Index', [
            'teams' => $teams,
            'countries' => Country::all()
        ]);
    }
    public function create()
    {
        return redirect()->back();
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'required|string|max:255',
        //     'country_id' => 'required|numeric',
        // ]);

        // $team = Team::create([
        //     'name' => $request->name,
        //     'description' => $request->description,
        //     'country_id' => $request->country_id,
        // ]);
        return redirect()->back();
    }
    public function show($team)
    {
        return Inertia::render('teams/show', [
            'team' => $team,
        ]);
    }
}
