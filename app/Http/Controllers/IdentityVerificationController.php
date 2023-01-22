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
            'identity_front_image' => [
                'nullable',
            ],
            'identity_back_image' => [
                'nullable',
            ],
            'identity_selfie_image' => [
                'nullable',
            ],
        ]);

        $data = collect($data)->filter()->toArray();

        unset($data['identity_front_image']);
        unset($data['identity_back_image']);
        unset($data['identity_selfie_image']);

        if ($request->hasFile('identity_front_image')) {
            $data['identity_front_image'] = $request->file('identity_front_image')->store('identity-images');
        }

        if ($request->hasFile('identity_back_image')) {
            $data['identity_back_image'] = $request->file('identity_back_image')->store('identity-images');
        }

        $request->whenFilled('identity_selfie_image', function () use ($request, &$data) {
            Storage::put($request->user()->email.'_selfie_image.png',
                base64_decode(Str::replace('data:image/octet-stream;base64,', '',
                    $request->input('identity_selfie_image'))));

            $data['identity_selfie_image'] = $request->user()->email.'_selfie_image.png';
        });

        $request->user()->update($data);

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
