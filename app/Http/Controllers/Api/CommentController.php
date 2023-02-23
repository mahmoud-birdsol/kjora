<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function index(Request $request)
    {

    }

    public function store(CommentStoreRequest $request)
    {
        Comment::create($request->validated());

        return response()->json([
            'message' => 'Comment Added Successfully'
        ]);
    }
}
