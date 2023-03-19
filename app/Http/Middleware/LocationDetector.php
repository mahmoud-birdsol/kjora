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
        if ($userClintIp == '127.0.0.1')
        {
            $userClintIp = '24.48.0.2';
        }
        if ($user->last_known_ip != $userClintIp || $user->last_known_ip == null) {
            $userGeolocationData = \App\Services\Geolocator\IpInfo::locate($userClintIp);
            $user->update([
                'last_known_ip'=>$userGeolocationData->ip(),
                'current_country'=>$userGeolocationData->country(),
                'current_region'=>$userGeolocationData->region(),
                'current_city'=>$userGeolocationData->city(),
                'current_latitude'=>$userGeolocationData->latitude(),
                'current_longitude'=>$userGeolocationData->longitude(),
            ]);

        }
        return $next($request);
    }
}
