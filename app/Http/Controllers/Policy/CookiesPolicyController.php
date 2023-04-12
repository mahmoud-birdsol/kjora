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
     */
    public function index(Request $request): Response
    {
        return Inertia::render('CookiesPolicy', [
            'cookies' => CookiePolicy::latest()->whereNotNull('published_at')->orderBy('published_at', 'desc')->first(),
        ]);
    }

    /**
     * verify cookie.
     */
    public function store(
        Request $request,
        CookiePolicy $cookiePolicy,
        AssignTheCookiesVersion $assignTheCookiesVersion
    ): RedirectResponse {
        $user = $request->user();
        ($assignTheCookiesVersion)($user, $cookiePolicy);
        FlashMessage::make()->success(
            message: __('Cookies approved successfully')
        )->closeable()->send();

        return redirect()->intended();
    }
}
