<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\CommentCreatedNotification;
use App\Notifications\MentionNotification;
use App\Notifications\ReplyCreatedNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use ReflectionClass;

class CommentController extends Controller
{
    /**
     * Load the comments of the model
     *
     * @throws \ReflectionException
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $modelType = (new ReflectionClass($request->input('commentable_type')))->newInstance();

        $model = $modelType->findOrFail($request->input('commentable_id'));

        return CommentResource::collection($model->comments->load('user')->load('replies')->load('likes.user:id,username,first_name,last_name'));
    }

    /**
     * Store a new Comment
     *
     * @throws \ReflectionException
     */
    public function store(CommentStoreRequest $request): JsonResponse
    {
        $comment = Comment::create($request->validated());

        $modelType = (new ReflectionClass($request->input('commentable_type')))->newInstance();

        $media = $modelType->findOrFail($request->input('commentable_id'));

        $user = User::find($media->user->id);

        if ($request->user()->id !== $user->id) {
            $user->notify(new CommentCreatedNotification($user, $request->user(), $media));
        }

        if ($request->has('parent_id') && ! is_null($request->input('parent_id'))) {
            $parentComment = Comment::find($request->input('parent_id'));
            if ($parentComment->user->id != $request->user()->id) {
                $parentComment->user->notify(new ReplyCreatedNotification($user, $request->user(), $media));
            }
        }
        $mentions = [];

        preg_match_all("(\@(?P<names>[a-zA-Z\-\_]+))", $comment->body, $mentions);

        $mentions = collect(collect($mentions)->pop())->flatten()->unique();

        foreach ($mentions as $mention) {
            $user = User::where('username', Str::replace('_', ' ', $mention))
                ->first();
            if($user){
                $user->notify(new MentionNotification($comment));
            }
        }

        return response()->json([
            'message' => 'Comment Added Successfully',
        ]);
    }
}
