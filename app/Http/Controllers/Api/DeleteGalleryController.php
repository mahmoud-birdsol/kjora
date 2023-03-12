<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MediaLibrary;

class DeleteGalleryController extends Controller
{
    /**
     * Delete the current media object
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(MediaLibrary $mediaLibrary)
    {
        $mediaLibrary->delete();

        return response()->json([
            'message' => 'Media Deleted Successfully',
        ]);
    }
}
