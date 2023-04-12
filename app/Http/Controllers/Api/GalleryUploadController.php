<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryUploadRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class GalleryUploadController extends Controller
{
    /**
     * Upload user media gallery
     *
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
