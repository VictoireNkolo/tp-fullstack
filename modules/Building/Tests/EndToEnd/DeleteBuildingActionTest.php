<?php

namespace Building;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\Infrastructure\Building\Models\Building;
use Module\Infrastructure\Company\Models\Company;
use Module\Infrastructure\User\Models\User;
use Tests\TestCase;

class DeleteBuildingActionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_can_soft_delete_a_building()
    {
        $buildingId = '001';
        $eCompany = Company::factory()->create();
        Building::factory()->create(
            [
                'uuid'         => $buildingId,
                'company_uuid' => $eCompany->uuid
            ]
        );
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/app/building/delete', ['id' => $buildingId]);

        $response->assertStatus(200);
        $this->assertTrue($response->json(['isDeleted']));
    }
}