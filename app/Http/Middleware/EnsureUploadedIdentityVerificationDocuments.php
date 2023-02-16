<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class EnsureUploadedIdentityVerificationDocuments
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
        if (! $request->user()->hasUploadedVerificationDocuments()) {
            $request->session()->flash('message', [
                'type' => 'warning',
                'body' => 'Please verify your identity.',
                'action' => [
                    'url' => route('identity.verification.create'),
                    'text' => 'Upload Verification Documents',
                ],
            ]);
        }

        return $next($request);
    }
}
