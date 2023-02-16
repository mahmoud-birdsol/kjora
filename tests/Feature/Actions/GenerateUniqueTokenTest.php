<?php

namespace Tests\Feature\Actions;

use App\Actions\GenerateUniqueToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenerateUniqueTokenTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_it_generates_a_unique_token()
    {
        $action = resolve(GenerateUniqueToken::class);

        $firstToken = $action('join_platform_tokens');
        $secondToken = $action('join_platform_tokens');

        $this->assertNotEquals($firstToken, $secondToken);
    }
}
