<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function index()
    {
        $teams = Team::with(['players', 'country'])->paginate(6);
        return Inertia::render('requests/Index', [
            'teams' => $teams
        ]);
    }
}
