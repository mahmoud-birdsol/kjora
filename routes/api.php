<?php

use App\Http\Controllers\Api\ClubController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\DeleteGalleryController;
use App\Http\Controllers\Api\GalleryUploadController;
use App\Http\Controllers\Api\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('clubs', [
    ClubController::class,
    'index'
])->name('api.clubs');

Route::get(
    'chats/{conversation}/messages', [
        MessageController::class,
        'index'
    ]
)->middleware('auth:sanctum')->name('api.messages.index');

Route::post(
    'chats/{conversation}/messages', [
    MessageController::class,
    'store'
])->middleware('auth:sanctum')->name('api.messages.store');

Route::post('posts', function (Request $request) {
    $post = \App\Models\Post::create([
        'user_id' => $request->user()->id,
        'caption' => $request->input('caption')
    ]);

    $cover = $post->addMedia($request->file('cover'))->toMediaCollection('gallery');

    $post->update([
        'cover_id' => $cover->id
    ]);

    return response()->json([
        'message' => 'Post created successfully'
    ]);
});


Route::post(
    'gallery/upload',
    GalleryUploadController::class
)->middleware('auth:sanctum')->name('api.gallery.upload');

Route::delete(
    'gallery/{mediaLibrary}/delete',
    DeleteGalleryController::class
)->middleware('auth:sanctum')->name('api.gallery.destroy');

Route::get('gallery/comments', [CommentController::class, 'index'])
    ->middleware('auth:sanctum')
    ->name('api.gallery.comments');

Route::post('gallery/comments', [CommentController::class, 'store'])
    ->middleware('auth:sanctum')
    ->name('api.gallery.comments.store');


Route::post('/elvis-has-left-the-building', function (Request $request) {
    $request->user()->forceFill([
        'last_seen_at' => now(),
    ])->save();
})->middleware('auth:sanctum')->name('api.user.left');
