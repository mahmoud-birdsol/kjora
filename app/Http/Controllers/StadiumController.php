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
        $request->merge([
            'user_id' => $request->user_id,
            'approved_at' => now(),
        ]);

        Stadium::create($request->all());

        return redirect()->back();
    }
}
