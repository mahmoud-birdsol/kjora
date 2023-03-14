<?php

namespace App\Http\Controllers\Policy;

use App\Actions\Verification\AssignTheTermsVersion;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\TermsAndConditions;
use App\Models\User;
use App\Services\FlashMessage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TermsAndConditionController extends Controller
{
    /**
     * Display terms and condition
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('TermsOfService', [
            'terms' => TermsAndConditions::latest()->whereNotNull('published_at')->orderBy('published_at', 'desc')->first()
        ]);
    }
    /**
     * verify terms and condition.
     *
     * @param \Illuminate\Http\Request $request
     * @param TermsAndConditions $termsAndConditions
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(
        Request $request,
        TermsAndConditions $termsAndConditions,
        AssignTheTermsVersion $assignTheTermsVersion
    ): RedirectResponse {
        $user =  $request->user();
        ($assignTheTermsVersion)($user, $termsAndConditions);
        FlashMessage::make()->success(
            message: 'Terms approved successfully'
        )->closeable()->send();

        return redirect()->intended();
    }
}
