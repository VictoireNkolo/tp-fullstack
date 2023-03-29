<?php

namespace Building;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\Infrastructure\Building\Models\Building;
use Module\Infrastructure\Company\Models\Company;
use Module\Infrastructure\User\Models\User;
use Tests\TestCase;

class GetBuildingActionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_can_get_a_building()
    {
        $user = User::factory()->create();
        $eCompany = Company::factory()->create();
        $eBuilding = Building::factory()->create(
            [
                'company_uuid' => $eCompany->uuid,
                'is_active' => true,
                'is_deleted' => false
            ]
        );

        $response = $this->actingAs($user)->get('/app/building/' . $eBuilding->uuid);

        $response->assertStatus(200);
        $this->assertTrue($response['status']);
        $this->assertNotEmpty($response['building']);
    }
}