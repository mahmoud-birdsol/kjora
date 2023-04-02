<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryUploadRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryUploadController extends Controller
{
    /**
     * Upload user media gallery
     *
     * @param \App\Http\Requests\GalleryUploadRequest $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\JsonResponse
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function __invoke(GalleryUploadRequest $request, Post $post): JsonResponse
    {
        $post->addMedia($request->file('gallery'))->toMediaCollection('gallery');

        return response()->json([
            'message' => 'File uploaded successfully',
        ]);
    }
}
