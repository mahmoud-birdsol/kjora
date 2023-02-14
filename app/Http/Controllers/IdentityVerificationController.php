<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyAdminsOfVerificationRequest;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
                'required',
                'string',
                Rule::in(Country::all()->pluck('name')),
            ],
            'identity_type' => [
                'required',
                'string',
                Rule::in([
                    'passport',
                    'national_id',
                ]),
            ],
            'identity_front_image' => [
                'required',
            ],
            'identity_back_image' => [
                'required',
            ],
            'identity_selfie_image' => [
                'required',
            ],
        ]);

        $data = collect($data)->filter()->toArray();

        unset($data['identity_front_image']);
        unset($data['identity_back_image']);
        unset($data['identity_selfie_image']);

        $request->user()->update($data);

        if ($request->hasFile('identity_front_image')) {
            $request->user()->addMediaFromRequest('identity_front_image')->toMediaCollection('identity_front_image');
        }

        if ($request->hasFile('identity_back_image')) {
            $request->user()->addMediaFromRequest('identity_back_image')->toMediaCollection('identity_back_image');
        }

        if ($request->has('identity_selfie_image') && Str::contains($request->input('identity_selfie_image'), 'data:image')) {
            /** @var \App\Models\User $user */
            $user = $request->user();
            $user
                ->addMediaFromBase64($request->input('identity_selfie_image'))
                ->setFileName($user->id . '_selfie_image.jpg')
                ->withCustomProperties(['mime-type' => 'image/jpeg'])
                ->toMediaCollection('identity_selfie_image');
        }

        if ($request->user()->hasUploadedVerificationDocuments()) {
            $request->session()->flash('message', [
                'type' => 'success',
                'body' => 'Thank you for uploading your verification documents we will verify the information provided and get back to you shortly.',
            ]);
        }

        NotifyAdminsOfVerificationRequest::dispatch($request->user());

        return redirect()->back();
    }
}
