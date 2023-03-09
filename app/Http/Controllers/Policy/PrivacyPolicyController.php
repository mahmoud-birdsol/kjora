<?php

namespace App\Http\Controllers\Policy;

use App\Actions\Verification\AssignThePrivacyVersion;
use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use App\Services\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PrivacyPolicyController extends Controller
{
    /**
     * Display policy
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('PrivacyPolicy', [
            'policy' => PrivacyPolicy::latest()->first()
        ]);
    }
    /**
     * verify policy.
     *
     * @param \Illuminate\Http\Request $request
     * @param PrivacyPolicy $privacyPolicy
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(
        Request $request,
        PrivacyPolicy $privacyPolicy ,
        AssignThePrivacyVersion $assignThePrivacyVersion
    ): RedirectResponse
    {
        $user =  $request->user();
        ($assignThePrivacyVersion)($user , $privacyPolicy);
        FlashMessage::make()->success(
            message: 'Private Policy approved successfully'
        )->closeable()->send();

        return redirect()->back();
    }
}
