<?php

namespace App\Http\Middleware;

use App\Services\FlashMessage;
use Closure;
use Illuminate\Http\Request;

class EnsurePhoneIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()->hasVerifiedPhone()) {
            FlashMessage::make()->warning(
                message: __('Please verify your phone number')
            )->action(route('phone.verify'), __('Verify phone number'))->closeable()->send();
        }

        return $next($request);
    }
}
