<?php

namespace App\Http\Middleware;

use App\Services\FlashMessage;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $review = $request->user()->reviewerReviews()->whereNull('reviewed_at')->first();
        if (!is_null($review)) {
            $request->session()->flash('message', [
                'type' => 'warning',
                'body' => 'You have a pending player to review',
                'action' => [
                    'url' => route('player.review.show', [
                        'review' => $review->id,
                        'reviewing_user' => Auth::id()
                    ]),
                    'text' => 'Review',
                ],
            ]);
        }
        return $next($request);
    }
}
