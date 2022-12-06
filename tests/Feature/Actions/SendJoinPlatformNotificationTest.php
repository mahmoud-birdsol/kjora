<?php

namespace Tests\Feature\Actions;

use App\Actions\SendJoinPlatformNotification;
use App\Models\User;
use App\Notifications\JoinPlatformNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendJoinPlatformNotificationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_it_creates_a_join_platform_token_for_user()
    {
        $user = User::factory()->create();

        $action = resolve(SendJoinPlatformNotification::class);

        $action($user);

        $this->assertDatabaseHas('join_platform_tokens', [
            'authenticatable_id' => $user->id,
            'authenticatable_type' => get_class($user),
        ]);
    }

    public function test_it_sends_join_platform_notification()
    {
        Notification::fake();

        $user = User::factory()->create();

        $action = resolve(SendJoinPlatformNotification::class);

        $action($user);

        Notification::assertSentTo($user, JoinPlatformNotification::class);
    }
}
