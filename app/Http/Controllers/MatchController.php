<?php

namespace App\Http\Controllers;

use App\Models\Match;
use App\Models\Stadium;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userTeams = auth()->user()->teams()->get();
        $matches = [
            '0' => [
                'team_1' => $userTeams[0],
                'team_2' => $userTeams[1],
                'point_team_1' => 3,
                'point_team_2' => 3,
                'stadium' => Stadium::first(),
            ]
        ];
        return Inertia::render('Match/Index', [
            'individualMatches' => $matches,
            'teamMatches' => $matches,
            'latestMatches' => []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Match/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function show($match)
    {
        return Inertia::render('Match/Show', [
            'match' => $match
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function edit($match)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $match)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function destroy($match)
    {
        //
    }
}
