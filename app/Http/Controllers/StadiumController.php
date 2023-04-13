<?php

namespace App\Http\Controllers;

use App\Http\Requests\StadiumRequest;
use App\Models\Stadium;
use App\Services\FlashMessage;
use Illuminate\Http\RedirectResponse;

class StadiumController extends Controller
{
    public function __invoke(StadiumRequest $request): RedirectResponse
    {
        Stadium::create([
            'name' => $request->input('name'),
            'longitude' => $request->input('longitude'),
            'latitude' => $request->input('latitude'),
            'google_place_id' => $request->input('google_place_id'),
            'user_id' => auth()->user()->id,
            'approved_at' => now(),
        ]);

        FlashMessage::make()->success(
            message: 'Stadium Created successfully and is pending approval'
        )->closeable()->send();

        return redirect()->back();
    }
}
