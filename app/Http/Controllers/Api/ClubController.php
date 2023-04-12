<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClubResource;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Club::query();

        $request->whenFilled('search', fn () => $query->where('name', 'LIKE', '%'.$request->input('search').'%'));

        return ClubResource::collection($query->paginate());
    }
}
