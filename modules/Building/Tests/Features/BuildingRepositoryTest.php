<?php

namespace TP\Building\Tests\Features;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TP\Building\Domain\BuildingEventState;
use TP\Building\Domain\Exceptions\ErrorOnSaveBuildingException;
use TP\Building\Infrastructure\Models\Building;
use TP\Building\Infrastructure\Repositories\EloquentBuildingRepository;
use TP\Shared\VO\Address;
use TP\Shared\VO\City;
use TP\Shared\VO\Id;
use TP\Shared\VO\Name;
use TP\Shared\VO\PostalCode;

class BuildingRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private EloquentBuildingRepository $buildingRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->buildingRepository = new EloquentBuildingRepository();
    }

    public function test_can_get_building_by_id()
    {
        $building = Building::factory()->create();

        $eBuilding = $this->buildingRepository->byId(new Id($building->uuid));

        $this->assertEquals($building->uuid, $eBuilding->id()->value());
    }

    /**
     * @throws ErrorOnSaveBuildingException
     */
    public function test_can_save_building()
    {
        $building = \TP\Building\Domain\Building::create(
            new Name('Immeuble test'),
            new Address('Biyem-Assi, Yaoundé'),
            new PostalCode('12345'),
            new City('Yaoundé'),
            null
        );
        $building->defineBuildingEventState(BuildingEventState::onSave);

        $this->buildingRepository->save($building);
        $eBuilding = Building::whereUuid($building->id()->value())->first();

        $this->assertNotNull($eBuilding->uuid);
    }

    /**
     * @throws ErrorOnSaveBuildingException
     */
    public function test_can_save_soft_deleted_building()
    {
        $dbBuilding = Building::factory()->create();
        $building = $dbBuilding->toDomain();
        $building->defineBuildingEventState(BuildingEventState::onDelete);

        $this->buildingRepository->save($building);
        $eBuilding = Building::whereUuid($building->id()->value())->first();

        $this->assertNotNull($eBuilding->uuid);
        $this->assertEquals(1, $eBuilding->is_deleted);
    }
}
