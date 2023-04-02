<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @param \App\Http\Requests\PostRequest $request
     * @return array
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function __invoke(PostRequest $request)
    {
        $post = Post::create([
            'user_id' => $request->user()->id,
            'caption' => $request->input('caption')
        ]);

        $cover = $post->addMedia($request->file('cover'))->toMediaCollection('gallery');

        $post->update([
            'cover_id' => $cover->id
        ]);

        return $post->toArray();
    }
}
