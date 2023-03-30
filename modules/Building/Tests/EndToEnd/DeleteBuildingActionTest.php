<?php

namespace TP\Building\Tests\EndToEnd;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TP\Building\Infrastructure\Models\Building;

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
        Building::factory()->create(
            [
                'uuid'         => $buildingId,
            ]
        );

        $response = $this->postJson('/tp/building/delete', ['id' => $buildingId]);

        $response->assertStatus(200);
        $this->assertTrue($response->json(['isDeleted']));
    }
}
