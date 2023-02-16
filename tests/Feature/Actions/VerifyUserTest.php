<?php

namespace Tests\Feature\Actions;

use App\Actions\Verification\VerifyUser;
use App\Models\User;
use App\Notifications\IdentityVerifiedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class VerifyUserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_it_marks_the_user_as_verified()
    {
        $action = resolve(VerifyUser::class);

        $user = User::factory()->create([
            'identity_verified_at' => null,
        ]);

        $action($user);

        $this->assertNotNull($user->refresh()->identity_verified_at);
    }

    public function test_sends_the_verified_notification()
    {
        Notification::fake();

        $action = resolve(VerifyUser::class);

        $user = User::factory()->create([
            'identity_verified_at' => null,
        ]);

        $action($user);

        Notification::assertSentTo($user, IdentityVerifiedNotification::class);
    }
}
