<?php

namespace Tests\Feature\Actions;

use App\Actions\Verification\SendVerifiedNotification;
use App\Models\User;
use App\Notifications\AccountVerifiedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendVerifiedNotificationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_it_sends_verified_notification()
    {
        Notification::fake();

        $user = User::factory()->create();

        $action = resolve(SendVerifiedNotification::class);

        $action($user);

        Notification::assertSentTo($user, AccountVerifiedNotification::class);
    }
}
