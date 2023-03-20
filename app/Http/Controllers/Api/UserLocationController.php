<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Geocoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLocationController extends Controller
{
    /**
     * Update the user location
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\Geocoder $geocoder
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(
        Request $request,
        Geocoder $geocoder
    )
    {
        $request->validate([
            'latitude' => [
                'required',
                'numeric',
            ],
            'longitude' => [
                'required',
                'numeric',
            ],
        ]);

        $address = collect($geocoder->getAddress($request->input('longitude'), $request->input('latitude')));

        if (Auth::check()) {
            Auth::user()->update([
                'current_latitude' => $request->input('latitude'),
                'current_longitude' => $request->input('longitude'),
                'current_city' => isset($address[4]) ? $address[4]['long_name'] : null,
                'current_region' => isset($address[3]) ? $address[3]['long_name'] : null,
                'current_country' =>  isset($address[5]) ? $address[5]['long_name'] : null,
                'geo_location' => true
            ]);
        }

        return response()->json([
            'message' => 'Location Updated Successfully',
        ]);
    }
}
