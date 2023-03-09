<?php

namespace App\Listeners;


use App\Actions\Verification\AssignThePrivacyVersion;
use App\Models\PrivacyPolicy;
use Illuminate\Auth\Events\Registered;

class VerifyPrivacyPolicy
{

    private AssignThePrivacyVersion $assignThePrivacyVersion;

    public function __construct(AssignThePrivacyVersion $assignThePrivacyVersion)
    {
        $this->assignThePrivacyVersion = $assignThePrivacyVersion;
    }
    /**
     * Create a new event instance.
     *
     * @return void
     */
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event )
    {
        $user = $event->user;
        $lastPolicy = PrivacyPolicy::latest()->first();
        $this->assignThePrivacyVersion->__invoke($user , $lastPolicy);

    }



}
