<?php

namespace App\Http\Controllers\Policy;

use App\Actions\Verification\AssignTheCookiesVersion;
use App\Http\Controllers\Controller;
use App\Models\CookiePolicy;
use App\Services\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CookiesPolicyController extends Controller
{
    /**
     * Display cookie
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('PrivacyPolicy', [
            'cookies' => CookiePolicy::latest()->first()
        ]);
    }
    /**
     * verify cookie.
     *
     * @param \Illuminate\Http\Request $request
     * @param CookiePolicy $cookiePolicy
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(
        Request $request,
        CookiePolicy $cookiePolicy ,
        AssignTheCookiesVersion $assignTheCookiesVersion
    ): RedirectResponse
    {
        $user =  $request->user();
        ($assignTheCookiesVersion)($user , $cookiePolicy);
        FlashMessage::make()->success(
            message: 'Cookies approved successfully'
        )->closeable()->send();

        return redirect()->back();
    }
}
