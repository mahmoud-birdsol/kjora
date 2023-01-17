<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
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
        if (! $request->user()->hasVerifiedEmail()) {
            $request->session()->flash('message', [
                'type' => 'warning',
                'body' => 'Please verify your email through the link sent to your email.',
                'action' => [
                    'url' => route('verification.notice'),
                    'text' => 'Request another email',
                ]
            ]);
        }

        return $next($request);
    }
}
