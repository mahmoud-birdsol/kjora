<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Click;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdvertisementController extends Controller
{
    /**
     * Record the click on the advertisement and redirect to the advertisement url
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Advertisement $advertisement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, Advertisement $advertisement): RedirectResponse
    {
        Click::create([
            'advertisement_id' => $advertisement,
            'ip' => $request->user()->last_known_ip,
            'source' => $request->input('source'),
            'user_id' => $request->user()->id
        ]);

        return redirect()->away($advertisement->link);
    }
}
