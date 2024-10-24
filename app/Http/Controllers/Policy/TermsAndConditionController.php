<?php

namespace App\Http\Controllers\Policy;

use App\Actions\Verification\AssignTheTermsVersion;
use App\Http\Controllers\Controller;
use App\Models\TermsAndConditions;
use App\Services\FlashMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TermsAndConditionController extends Controller
{
    /**
     * Display terms and condition
     */
    public function index(Request $request): Response
    {
        return Inertia::render('TermsOfService', [
            'terms' => TermsAndConditions::latest()->whereNotNull('published_at')->orderBy('published_at', 'desc')->first(),
        ]);
    }

    /**
     * verify terms and condition.
     */
    public function store(
        Request $request,
        TermsAndConditions $termsAndConditions,
        AssignTheTermsVersion $assignTheTermsVersion
    ): RedirectResponse {
        $user = $request->user();
        ($assignTheTermsVersion)($user, $termsAndConditions);
        FlashMessage::make()->success(
            message: __('Terms approved successfully')
        )->closeable()->send();

        return redirect()->intended();
    }
}
