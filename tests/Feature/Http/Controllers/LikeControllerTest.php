<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Notifications\LikeCreatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class LikeControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_it_likes_a_likeable()
    {
        Notification::fake();

        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $this->actingAs($user)
            ->post(route('like.store'), [
                'likeable_id' => $comment->id,
                'likeable_type' => get_class($comment),
            ])->assertRedirect();

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'likeable_id' => $comment->id,
            'likeable_type' => get_class($comment),
        ]);

        Notification::assertSentTo($comment->owner(), LikeCreatedNotification::class);

        $this->assertCount(1, $comment->likes);
    }

    public function test_it_unlikes_a_likeable()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        Like::create([
            'user_id' => $user->id,
            'likeable_id' => $comment->id,
            'likeable_type' => get_class($comment),
        ]);

        // When I submit a request to unlike a comment
        $this->actingAs($user)
            ->delete(route('like.destroy'), [
                'likeable_id' => $comment->id,
                'likeable_type' => get_class($comment),
            ])->assertRedirect();


        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'likeable_id' => $comment->id,
            'likeable_type' => get_class($comment),
        ]);

        $this->assertCount(0, $comment->likes);
    }
}
