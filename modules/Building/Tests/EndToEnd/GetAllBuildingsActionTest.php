<?php

namespace Building;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\Infrastructure\Building\Models\Building;
use Module\Infrastructure\Company\Models\Company;
use Module\Infrastructure\User\Models\User;
use Tests\TestCase;

class GetAllBuildingsActionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_can_get_all_buildings()
    {
        $user = User::factory()->create();
        $eCompany = Company::factory()->create();
        Building::factory()->create(
            [
                'company_uuid' => $eCompany->uuid,
                'is_active' => true,
                'is_deleted' => false
            ]
        );
        Building::factory()->create(
            [
                'company_uuid' => $eCompany->uuid,
                'is_active' => true,
                'is_deleted' => false
            ]
        );

        $response = $this->actingAs($user)->get('/app/buildings/' . $eCompany->uuid);

        $response->assertStatus(200);
        $this->assertTrue($response['status']);
        $this->assertNotEmpty($response['buildings']);
    }
}