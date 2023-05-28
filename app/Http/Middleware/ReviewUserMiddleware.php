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
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $review = $request->user()?->reviewerReviews()?->whereNull('reviewed_at')?->first();
        if ($request->user()?->hasPendingReviews()) {
            FlashMessage::make()->warning(
                message: __('You have a pending player to rate')
            )->action(route('player.review.show', [
                'review' => $review->id,
                'reviewing_user' => Auth::id(),
            ]), __('Rate'))->closeable()->send();
        }

        return $next($request);
    }
}
