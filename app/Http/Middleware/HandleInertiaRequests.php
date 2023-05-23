<?php

namespace App\Http\Middleware;

use App\Models\ReportOption;
use App\Models\Social;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
            ],
            'queryParams' => fn () => $request->query(),

            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },

            'url' => url(),

            'socials' => fn () => Social::active()->get(),

            'notifications' => fn () => $request->user() ? $request->user()->unreadNotifications : [],

            'reportOptions' => fn () => ReportOption::all(),

            'locale' => app()->getLocale(),

            'greetings' => [
                'ar' => nova_get_setting('greetings_text_ar'),
                'en' => nova_get_setting('greetings_text_en'),
            ],
            'distanceInvitationLimit' => (int) nova_get_setting('distance_invitation_limit') ? (int) nova_get_setting('distance_invitation_limit') :  100 ,

            'maximumUploadNumberOfFiles' => nova_get_setting('maximum_upload_number_of_files') ?? 20
        ]);
    }
}
