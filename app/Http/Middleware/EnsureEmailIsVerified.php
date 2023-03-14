<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\FlashMessage;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()->hasVerifiedEmail()) {
            FlashMessage::make()->warning(
                message: __('Please verify your email through the link sent to your email.')
            )->action(route('verification.notice') , __('Request another email'))->closeable()->send();
        }

        return $next($request);
    }
}
