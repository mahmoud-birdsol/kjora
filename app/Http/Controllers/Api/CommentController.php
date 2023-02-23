<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\MediaLibrary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use ReflectionClass;

class CommentController extends Controller
{
    /**
     * Load the comments of the model
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \ReflectionException
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        /** @var Model $modelType */
        $modelType = new ReflectionClass($request->input('commentable_type'));

        $model = $modelType->findOrFail($request->input('commentable_id'));

        return CommentResource::collection($model->comments()->paginate(12)->load('replies'));
    }

    /**
     * Store a new Comment
     *
     * @param \App\Http\Requests\CommentStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CommentStoreRequest $request): JsonResponse
    {
        Comment::create($request->validated());

        return response()->json([
            'message' => 'Comment Added Successfully'
        ]);
    }
}
