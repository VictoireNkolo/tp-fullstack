<?php

namespace TP\Building\Tests\EndToEnd;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TP\Building\Infrastructure\Models\Building;

class GetBuildingActionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_can_get_a_building()
    {
        $eBuilding = Building::factory()->create(['is_deleted' => false]);

        $response = $this->get('/tp/building/' . $eBuilding->uuid);

        $response->assertStatus(200);
        $this->assertTrue($response['status']);
        $this->assertNotEmpty($response['building']);
    }
}
