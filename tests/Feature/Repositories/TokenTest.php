<?php

namespace Tests\Feature\Repositories;

use App\Models\User;
use App\Repositories\Token;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class TokenTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_it_creates_a_token()
    {
        $user = User::factory()->create();

        $token = Str::random(16);

        Token::make('join_platform_tokens')->create($user, $token);

        $this->assertDatabaseHas('join_platform_tokens', [
            'authenticatable_id' => $user->id,
            'authenticatable_type' => get_class($user),
            'token' => $token,
        ]);
    }

    public function test_it_finds_a_token()
    {
        $user = User::factory()->create();

        $token = Str::random(16);

        Token::make('join_platform_tokens')->create($user, $token);

        $this->assertInstanceOf(Token::class, Token::make('join_platform_tokens')->find($token));
    }

    public function test_it_throws_a_not_found_exception()
    {
        $this->expectException(ModelNotFoundException::class);


        Token::make('join_platform_tokens')->find(Str::random());
    }

    public function test_it_validates_a_token()
    {
        $user = User::factory()->create();

        $token = Str::random(16);

        Token::make('join_platform_tokens')->create($user, $token);

        $this->assertTrue(Token::make('join_platform_tokens')->validate($token));

        $this->expectException(ModelNotFoundException::class);

        $this->assertFalse(Token::make('join_platform_tokens')->validate(Str::random()));
    }

    public function test_it_retrieves_the_authenticatable()
    {
        $user = User::factory()->create();

        $token = Str::random(16);

        $repository = Token::make('join_platform_tokens')->create($user, $token);

        $this->assertInstanceOf(User::class, $repository->authenticatable());
    }

    public function test_it_retrieves_the_guard()
    {
        $user = User::factory()->create();

        $token = Str::random(16);

        $repository = Token::make('join_platform_tokens')->create($user, $token);

        $this->assertEquals('web', $repository->guard());
    }
}
