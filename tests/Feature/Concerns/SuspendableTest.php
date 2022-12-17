<?php

namespace Tests\Feature\Concerns;

use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SuspendableTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_it_can_be_suspended()
    {
        $country = Country::factory()->create();

        $country->suspend();

        $this->assertTrue($country->isSuspended);
    }

    public function test_it_is_active_by_default()
    {
        $country = Country::factory()->create();

        $this->assertTrue($country->isActive);
    }

    public function test_it_can_be_reinstated()
    {
        $country = Country::factory()->create();

        $country->suspend();

        $this->assertTrue($country->isSuspended);

        $country->activate();

        $this->assertTrue($country->isActive);
    }

    public function test_it_checks_if_suspended()
    {
        $country = Country::factory()->create();

        $country->suspend();

        $this->assertTrue($country->isSuspended);
    }

    public function test_it_checks_if_active()
    {
        $country = Country::factory()->create();

        $this->assertTrue($country->isActive);
    }

    public function test_it_filters_for_suspended_models()
    {
        $country = Country::factory()->create();
        Carbon::setTestNow(now());
        $country->suspend();

        $country = Country::factory()->create();
        Carbon::setTestNow(now());
        $country->suspend();

        $country = Country::factory()->create();
        Carbon::setTestNow(now());
        $country->suspend();
        Carbon::setTestNow(now()->addMinute());
        $country->activate();

        $this->assertCount(2, Country::suspended()->get());
    }

    public function test_it_filters_for_active_models()
    {
        Country::factory()->create();
        Country::factory()->create();
        Country::factory()->create();

        $country = Country::factory()->create();
        Carbon::setTestNow(now());
        $country->suspend();

        $country = Country::factory()->create();
        Carbon::setTestNow(now());
        $country->suspend();

        $country = Country::factory()->create();
        Carbon::setTestNow(now());
        $country->suspend();
        Carbon::setTestNow(now()->addMinute());
        $country->activate();

        $this->assertCount(4, Country::active()->get());
    }
}
