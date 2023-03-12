<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\FlashMessage;
use Closure;
use Illuminate\Http\Request;

class EnsureUploadedIdentityVerificationDocuments
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->hasVerifiedIdentity()) {
            return $next($request);
        }
        if (! $request->user()->hasUploadedVerificationDocuments()) {
            FlashMessage::make()->warning(
                message: __('Please verify your identity.')
            )->action(route('identity.verification.create') , __('Upload Verification Documents'))->closeable()->send();

        }

        return $next($request);
    }
}
