<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Notifications\LikeCreatedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'likeable_id' => ['required', 'integer'],
            'likeable_type' => ['required', 'string'],
        ]);

        $like = Like::create([
            'user_id' => $request->user()->id,
            'likeable_id' => $request->likeable_id,
            'likeable_type' => $request->likeable_type,
        ]);

        if ($like->likeable->owner()->id != $request->user()->id) {
            $like->likeable->owner()->notify(new LikeCreatedNotification($like->likeable, $like));
        }

        return redirect()->back();
    }

    public function destroy(Request $request): RedirectResponse
    {
        Like::where([
            'user_id' => $request->user()->id,
            'likeable_id' => $request->likeable_id,
            'likeable_type' => $request->likeable_type,
        ])->delete();

        return redirect()->back();
    }
}
