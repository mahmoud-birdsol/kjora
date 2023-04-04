<?php

namespace Tests\Feature;

use App\Models\Club;
use App\Models\Country;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_information_can_be_updated()
    {
        $country = Country::factory()->create();
        $club = Club::factory()->create();
        $position = Position::factory()->create();

        $this->actingAs($user = User::factory()->create());

        $response = $this->put('/user/profile-information', [
            'username' => 'Test Name',
            'email' => 'test@example.com',
            'first_name' => 'Test',
            'last_name' => 'Name',
            'country_id' => $country->id,
            'club_id' => $club->id,
            'position_id' => $position->id
        ]);


        $this->assertEquals('Test Name', $user->fresh()->username);
        $this->assertEquals('test@example.com', $user->fresh()->email);
    }
}
