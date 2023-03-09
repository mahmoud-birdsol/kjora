<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryUploadController extends Controller
{
    /**
     * Upload user media gallery
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'gallery' => [
                'max:10240',
            ],
        ]);
        /** @var \App\Models\User $user */
        $user = $request->user();

        $user->addMedia($request->file('gallery'))->toMediaCollection('gallery');

        return response()->json([
            'message' => 'File uploaded successfully',
        ]);
    }
}
