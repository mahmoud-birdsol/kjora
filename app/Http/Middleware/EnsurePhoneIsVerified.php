<?php

namespace App\Http\Middleware;

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
        if (! $request->user()->hasVerifiedPhone()) {
            $request->session()->flash('message', [
                'type' => 'warning',
                'body' => 'Please verify your phone number.',
                'action' => [
                    'url' => route('phone.verify'),
                    'text' => 'Verify phone number',
                ],
            ]);
        }

        return $next($request);
    }
}
