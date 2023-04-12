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
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        app()->setLocale(config('app.locale'));

        if (Auth::check()) {
            app()->setLocale(auth()->user()->locale);
        } elseif (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }
        if (auth('admin')->user()) {
            app()->setLocale(auth('admin')->user()->locale);

            if (app()->getLocale() == 'ar') {
                Nova::enableRTL();
            }
        }

        return $next($request);
    }
}
