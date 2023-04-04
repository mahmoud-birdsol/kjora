<?php

namespace Tests\Feature\Controllers;

use App\Models\Admin;
use App\Models\States\Free;
use App\Models\User;
use App\Repositories\Token;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class JoinPlatformControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_it_displays_the_form_to_join_platform()
    {
        $user = User::factory()->create([
            'state' => Free::class
        ]);
        $token = Str::random();

        Token::make('join_platform_tokens')->create($user, $token);

        $this->get(route('join-platform.create', $token))->assertSuccessful();
    }

    public function test_it_updates_the_user_password_and_name()
    {
        $user = Admin::factory()->create();
        $token = Str::random();

        Token::make('join_platform_tokens')->create($user, $token);

        $this->post(route('join-platform.store', $token), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'Pp@ssw0rd1!',
            'password_confirmation' => 'Pp@ssw0rd1!',
            'terms' => 'true',
        ])->assertRedirect('/nova')->assertSessionDoesntHaveErrors();
    }

    public function test_it_updates_the_admin_joined_platform_at_timestamp()
    {
        $user = Admin::factory()->create();
        $token = Str::random();

        $now = now();

        Carbon::setTestNow($now);

        Token::make('join_platform_tokens')->create($user, $token);

        $this->post(route('join-platform.store', $token), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'Pp@ssw0rd1!',
            'password_confirmation' => 'Pp@ssw0rd1!',
            'terms' => 'true',
        ])->assertRedirect('/nova')->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('admins', [
            'joined_platform_at' => $now,
        ]);
    }

    public function test_it_redirects_admins_to_nova()
    {
        $user = Admin::factory()->create();
        $token = Str::random();

        Token::make('join_platform_tokens')->create($user, $token);

        $this->post(route('join-platform.store', $token), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'Pp@ssw0rd1!',
            'password_confirmation' => 'Pp@ssw0rd1!',
            'terms' => 'true',
        ])->assertRedirect('/nova')->assertSessionDoesntHaveErrors();
    }
}
