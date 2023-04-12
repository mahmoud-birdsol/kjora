<?php

namespace App\Http\Middleware;

use App\Services\FlashMessage;
use Closure;
use Illuminate\Http\Request;

class EnsureUploadedIdentityVerificationDocuments
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()->hasUploadedVerificationDocuments() && ! $request->user()->hasVerifiedPersonalIdentity()) {
            FlashMessage::make()->warning(
                message: __('Please Upload Your Verification Documents .')
            )->action(route('identity.verification.create'), __('Upload Verification Documents'))->closeable()->send();
        } elseif (! $request->user()->hasVerifiedPersonalIdentity()) {
            FlashMessage::make()->warning(
                message: __('Please wait to verify your identity.')
            )->closeable()->send();
        }

        return $next($request);
    }
}
