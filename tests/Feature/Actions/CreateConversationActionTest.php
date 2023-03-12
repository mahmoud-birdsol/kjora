<?php

namespace Tests\Feature\Actions;

use App\Actions\CreateConversationAction;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateConversationActionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    //create a test case that tests that the action creates a new conversation between two players
    public function test_it_creates_a_conversation_between_two_players()
    {
        $playerOne = User::factory()->create();
        $playerTwo = User::factory()->create();

        $invitation = Invitation::factory()
            ->for($playerOne, 'invitingPlayer')
            ->for($playerTwo, 'invitedPlayer')
            ->create();

        $action = resolve(CreateConversationAction::class);

        $action($invitation);

        $this->assertTrue($playerOne->conversations()->where('user_id', $playerOne->id)->count() > 0);
        $this->assertTrue($playerTwo->conversations()->where('user_id', $playerTwo->id)->count() > 0);
    }
}
