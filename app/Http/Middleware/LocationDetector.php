<?php

namespace App\Http\Middleware;

use App\Services\Geolocator\ClientIpInfo;
use Closure;
use Illuminate\Http\Request;

class LocationDetector
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $userClintIp = \Request::ip();
        $userClintIp = '24.48.0.2';
        if($user->last_known_ip != $userClintIp || $user->last_known_ip == null ){
            $userGeolocationData = \App\Services\Geolocator\IpInfo::locate( $userClintIp);
            $user->setAttribute( 'last_known_ip' , $userGeolocationData->ip() );
            $user->setAttribute( 'current_country' , $userGeolocationData->country());
            $user->setAttribute( 'current_region' , $userGeolocationData->region() );
            $user->setAttribute( 'current_city' , $userGeolocationData->city() );
            $user->setAttribute( 'current_latitude' , $userGeolocationData->latitude());
            $user->setAttribute( 'current_longitude' , $userGeolocationData->longitude());
            $user->save();
        }
        return $next($request);
    }
}
