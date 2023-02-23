<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MediaLibrary;
use Illuminate\Http\Request;

class DeleteGalleryController extends Controller
{
    /**
     * Delete the current media object
     *
     * @param \App\Models\MediaLibrary $mediaLibrary
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(MediaLibrary $mediaLibrary)
    {
        $mediaLibrary->delete();

        return response()->json([
            'message' => 'Media Deleted Successfully'
        ]);
    }
}
