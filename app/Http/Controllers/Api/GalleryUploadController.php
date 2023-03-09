<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryUploadController extends Controller
{
    /**
     * Upload user media gallery
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\JsonResponse
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function __invoke(Request $request, Post $post): JsonResponse
    {
        $request->validate([
            'gallery' => [
                'max:10240'
            ]
        ]);

        $post->addMedia($request->file('gallery'))->toMediaCollection('gallery');

        return response()->json([
            'message' => 'File uploaded successfully'
        ]);
    }
}
