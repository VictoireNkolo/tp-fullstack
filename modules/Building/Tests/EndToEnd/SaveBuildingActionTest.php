<?php

namespace Building;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\Infrastructure\Building\Models\Building;
use Module\Infrastructure\Company\Models\Company;
use Module\Infrastructure\User\Models\User;
use Tests\TestCase;

class SaveBuildingActionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_can_create_a_building()
    {
        $data = $this->buildData();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/app/building/save', $data);

        $response->assertStatus(200);
        $this->assertTrue($response->json(['isSaved']));
        $this->assertNotNull($response->json(['id']));
    }

    public function test_can_update_existing_building()
    {
        $buildingId = '001';
        $data = $this->buildData(['id' => $buildingId]);
        Building::factory()->create(
            [
                'uuid'         => $buildingId,
                'company_uuid' => $data['company_id']
            ]
        );
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/app/building/save', $data);

        $response->assertStatus(200);
        $this->assertTrue($response->json(['isSaved']));
        $this->assertNotNull($response->json(['id']));
    }

    private function buildData($data = []): array
    {
        $eCompany = Company::factory()->create();
        $defaultData =
            [
                'company_id'  => $eCompany->uuid,
                'name'        => 'Immeuble Test',
                'address'     => 'Biyem-Assi, Yaoundé',
                'city'        => 'Yaoundé',
                'postal_code' => '0124',
                'id'          => null
            ];

        return array_merge($defaultData, $data);
    }
}