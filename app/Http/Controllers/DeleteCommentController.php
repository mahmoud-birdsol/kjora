<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteCommentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request ,Comment $comment)
    {
        if ( $comment->user_id ==  \auth()->user()->id) {
            $comment->delete();
        }
        return  redirect()->back();
    }
}
