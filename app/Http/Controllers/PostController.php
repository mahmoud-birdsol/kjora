<?php

namespace App\Http\Controllers;

use App\Actions\PostViewAction;
use App\Models\Post;
use App\Services\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
   /**
    * Show the post object
    *
    * @return \Inertia\Response
    */
   public function show(Post $post, PostViewAction $postViewAction)
   {
      $data = Post::where('id', $post->id)->with(['likes.user:id,username,first_name,last_name', 'user'])->first();
      ($postViewAction)($post);
      return Inertia::render('Posts/Show', [
         'post' => $data,
         'user' => $post->user,
      ]);
   }

   public function update(Request $request, Post $post): RedirectResponse
   {
      $data = $request->validate([
         'caption' => 'required',
      ]);

      $post->update($data);

      FlashMessage::make()->success(
         message: __('Post successfully updated.')
      )->closeable()->send();

      return redirect()->back();
   }

   /**
    * Delete the post
    *
    * @return \Illuminate\Http\RedirectResponse
    */
   public function destroy(Request $request, Post $post)
   {
      $post->delete();

      FlashMessage::make()->success(
         message: 'The Post has been deleted'
      )->closeable()->send();

      return redirect()->route('profile.show', $request->user());
   }
}
