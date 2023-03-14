<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Nova;

class SetLocaleMiddleware
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
        app()->setLocale(config('app.locale'));

        if(Auth::check()){
            app()->setLocale(auth()->user()->locale);
        }
        if (auth('admin')->user()){
            if (app()->getLocale() == 'ar') {
                Nova::enableRTL();
            }
            app()->setLocale(auth('admin')->user()->locale);

        }

        return $next($request);
    }
}
