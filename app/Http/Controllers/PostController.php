<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\FlashMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
        $post->getMedia('gallery')?->each(function (Media $media) {
            $media?->delete();
        });

        $post->delete();

        FlashMessage::make()->success(
            message: 'The Post has been deleted'
        )->closeable()->send();

        return redirect()->back();
    }
}
