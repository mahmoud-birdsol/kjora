<?php

namespace Tests\Feature\Actions;

use App\Actions\Verification\SendVerificationReminder;
use App\Models\User;
use App\Notifications\VerificationReminderNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendVerificationReminderTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_it_sends_verification_reminder_notification()
    {
        Notification::fake();

        $user = User::factory()->create();

        $action = resolve(SendVerificationReminder::class);

        $action($user);

        Notification::assertSentTo($user, VerificationReminderNotification::class);
    }
}
