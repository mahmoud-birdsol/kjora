<?php

namespace Tests\Feature;

use App\Models\Club;
use App\Models\Country;
use App\Models\Position;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_registration_screen_can_be_rendered()
    {
        if (! Features::enabled(Features::registration())) {
            return $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_registration_screen_cannot_be_rendered_if_support_is_disabled()
    {
        if (Features::enabled(Features::registration())) {
            return $this->markTestSkipped('Registration support is enabled.');
        }

        $response = $this->get('/register');

        $response->assertStatus(404);
    }

    public function test_new_users_can_register()
    {
        if (! Features::enabled(Features::registration())) {
            return $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->post('/register', [
            'username' => 'Test User',
            'first_name' => 'john',
            'last_name' => 'doe',
            'email' => 'test@example.com',
            'password' => 'Pp@ssw0rd1!',
            'password_confirmation' => 'Pp@ssw0rd1!',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
            'country_id' => Country::factory()->create()->id,
            'club_id' => Club::factory()->create()->id,
            'date_of_birth' => now()->subYears(20),
            'phone' => '+201118870334',
            'position_id' => Position::factory()->create()->id,
            'gender' => 'male',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('phone.verify'));
    }
}
