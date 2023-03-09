<?php

namespace App\Http\Middleware;

use App\Models\CookiePolicy;
use App\Models\PrivacyPolicy;
use App\Models\TermsAndConditions;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EnsurePoliciesVerified
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //check if user accept the same version of current version
        if ($this->termsConditionsVersionChecker($request->user()) != 0) {
            return Redirect::route('terms.and.condition.index');
        }
        if ($this->privacyPolicyVersionChecker($request->user()) != 0) {
            return Redirect::route('privacy.policy.index');
        }
        if ($this->cookiesVersionChecker($request->user()) != 0) {
            return Redirect::route('cookies.policy.index');
        }
        return $next($request);
    }

    /**
     * check if terms same version with user
     * @param User $user
     * @return bool|int
     */
    private function termsConditionsVersionChecker(User $user)
    {
        $useTermsVersion = $user->accepted_terms_and_conditions_version;
        $lastTerm = TermsAndConditions::latest()->first();

        return version_compare($useTermsVersion, $lastTerm->version);
    }
    /**
     * check if privacy policies same version with user
     * @param User $user
     * @return bool|int
     */
    private function privacyPolicyVersionChecker(User $user)
    {
        $usePrivacyVersion = $user->accepted_privacy_policy_version;
        $lastPrivacyPolicy = PrivacyPolicy::latest()->first();

        return version_compare($usePrivacyVersion, $lastPrivacyPolicy->version);
    }
    /**
     * check if Cookie same version with user
     * @param User $user
     * @return bool|int
     */
    private function cookiesVersionChecker(User $user)
    {
        $useCookieVersion = $user->accepted_cookie_policy_version;
        $lastCookie = CookiePolicy::latest()->first();

        return version_compare($useCookieVersion, $lastCookie->version);
    }
}
