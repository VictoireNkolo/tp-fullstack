<?php

namespace TP\Building\Tests\EndToEnd;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TP\Building\Infrastructure\Models\Building;

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

        $response = $this->postJson('/tp/building/save', $data);

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
            ]
        );

        $response = $this->postJson('/tp/building/save', $data);

        $response->assertStatus(200);
        $this->assertTrue($response->json(['isSaved']));
        $this->assertNotNull($response->json(['id']));
    }

    private function buildData($data = []): array
    {
        $defaultData =
            [
                'name'        => 'Immeuble Test',
                'address'     => 'Biyem-Assi, Yaoundé',
                'city'        => 'Yaoundé',
                'postal_code' => '0124',
                'type'        => 'Maison',
                'description' => null,
                'id'          => null
            ];

        return array_merge($defaultData, $data);
    }
}
