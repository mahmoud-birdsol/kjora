<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class IdentityVerificationController extends Controller
{
    /**
     * Display the form to upload the user verification documents.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Auth/VerifyIdentity', [
            'countries' => Country::active()->orderBy('name')->get(),
        ]);
    }

    /**
     * Update the user verification documents.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'identity_issue_country' => [
                'nullable',
                'string',
                Rule::in(Country::all()->pluck('name')),
            ],
            'identity_type' => [
                'nullable',
                'string',
                Rule::in([
                    'passport',
                    'national_id',
                ]),
            ],
        ]);

        $data = collect($data)->filter()->toArray();

        $request->user()->update($data);

        if ($request->user()->hasUploadedVerificationDocuments()) {
            $request->session()->flash('message', [
                'type' => 'success',
                'body' => 'Thank you for uploading your verification documents we will verify the information provided and get back to you shortly.',
            ]);
        }

        return redirect()->back();
    }
}
