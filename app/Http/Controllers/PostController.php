<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\FlashMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Show the post object
     *
     * @param \App\Models\Post $post
     * @return \Inertia\Response
     */
    public function show(Post $post)
    {
        return Inertia::render('Gallery/Show', [
            'post' => $post,
            'user' => $post->user
        ]);
    }

    /**
     * Delete the post
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post $post)
    {
        $post->media->delete();

        $post->delete();

        FlashMessage::make()->success(
            message: 'The Post has beend deleted'
        )->closeable()->send();

        return redirect()->back();
    }
}
