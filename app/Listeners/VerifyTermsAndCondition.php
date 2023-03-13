<?php

namespace App\Listeners;


use App\Actions\Verification\AssignTheTermsVersion;
use App\Models\TermsAndConditions;
use Illuminate\Auth\Events\Registered;

class VerifyTermsAndCondition
{

    private AssignTheTermsVersion $assignTheTermsVersion;

    public function __construct(AssignTheTermsVersion $assignTheTermsVersion)
    {
        $this->assignTheTermsVersion = $assignTheTermsVersion;
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
        $lastTerm = TermsAndConditions::latest()->whereNotNull('published_at')->first();
        $this->assignTheTermsVersion->__invoke($user , $lastTerm);

    }


}
