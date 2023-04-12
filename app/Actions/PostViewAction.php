<?php

namespace App\Actions;

use App\Models\Post;
use App\Models\PostView;

class PostViewAction
{
    /**
     * create post view if user doesn/'t show this post before
     */
    public function __invoke(Post $post): void
    {
        if ($post->user_id != auth()->user()->id) {
            $postView = PostView::where('post_id', $post->id)->whereHas('user', function ($query) {
                $query->where('id', auth()->user()->id);
            })->first();
            if (! $postView) {
                PostView::create(['post_id' => $post->id, 'user_id' => auth()->user()->id]);
            }
        }
    }
}
