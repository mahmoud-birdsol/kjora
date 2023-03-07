<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClubResource;
use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Club::query();

        $request->whenFilled('search', fn () => $query->where('name', 'LIKE', '%'.$request->input('search').'%'));

        return new ClubResource($query->paginate());
    }
}
