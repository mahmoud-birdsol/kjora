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
        $lastTerm = TermsAndConditions::latest()->first();
        $lastPrivacyPolicy = PrivacyPolicy::latest()->first();
        $lastCookie = CookiePolicy::latest()->first();

        //check if user accept the same version of current version
        if (($this->termsConditionsVersionChecker($request->user(), $lastTerm) != 0) && $lastTerm) {
            return Redirect::route('terms.and.condition.index');
        }
        if (($this->privacyPolicyVersionChecker($request->user(), $lastPrivacyPolicy) != 0) && $lastPrivacyPolicy) {
            return Redirect::route('privacy.policy.index');
        }
        if (($this->cookiesVersionChecker($request->user(), $lastCookie) != 0) && $lastCookie) {
            return Redirect::route('cookies.policy.index');
        }
        return $next($request);
    }

    /**
     * check if terms same version with user
     * @param User $user
     * @return bool|int
     */
    private function termsConditionsVersionChecker(User $user, $lastTerm)
    {
        $useTermsVersion = $user->accepted_terms_and_conditions_version;

        return $lastTerm ? version_compare($useTermsVersion, $lastTerm->version) : false;
    }
    /**
     * check if privacy policies same version with user
     * @param User $user
     * @return bool|int
     */
    private function privacyPolicyVersionChecker(User $user,  $lastPrivacyPolicy)
    {
        $usePrivacyVersion = $user->accepted_privacy_policy_version;

        return $lastPrivacyPolicy ?  version_compare($usePrivacyVersion, $lastPrivacyPolicy->version) : false;
    }
    /**
     * check if Cookie same version with user
     * @param User $user
     * @return bool|int
     */
    private function cookiesVersionChecker(User $user,  $lastCookie)
    {
        $useCookieVersion = $user->accepted_cookie_policy_version;

        return $lastCookie ? version_compare($useCookieVersion, $lastCookie->version) : false;
    }
}