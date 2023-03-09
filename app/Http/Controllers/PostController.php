<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\FlashMessage;
use Illuminate\Http\RedirectResponse;
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

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $request->validate([
            'caption' => 'required',
        ]);

        $post->update($data);

        FlashMessage::make()->success(
            message: 'Post successfully updated.'
        )->closeable()->send();

        return redirect()->back();
    }

    /**
     * Delete the post
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Post $post)
    {
        $post->delete();

        FlashMessage::make()->success(
            message: 'The Post has been deleted'
        )->closeable()->send();

        return redirect()->route('profile.show', $request->user());
    }
}
