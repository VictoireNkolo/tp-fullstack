<?php

namespace Module\Tests\Features\Building;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\Domain\Building\BuildingEventState;
use Module\Domain\Building\Exceptions\ErrorOnSaveBuildingException;
use Module\Infrastructure\Building\Models\Building;
use Module\Infrastructure\Building\Repositories\EloquentBuildingRepository;
use Module\Infrastructure\Company\Models\Company;
use Module\Shared\VO\Address;
use Module\Shared\VO\City;
use Module\Shared\VO\Id;
use Module\Shared\VO\Name;
use Module\Shared\VO\PostalCode;
use Tests\TestCase;

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
        $dbCompany = Company::factory()->create();
        $building = \Module\Domain\Building\Building::create(
            new Name('Immeuble test'),
            new Address('Biyem-Assi, Yaoundé'),
            new PostalCode('12345'),
            new City('Yaoundé'),
            new Id($dbCompany->uuid),
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
        $dbCompany = Company::factory()->create();
        $dbBuilding = Building::factory()->create(['company_uuid' => $dbCompany->uuid]);
        $building = $dbBuilding->toDomain();
        $building->defineBuildingEventState(BuildingEventState::onDelete);

        $this->buildingRepository->save($building);
        $eBuilding = Building::whereUuid($building->id()->value())->first();

        $this->assertNotNull($eBuilding->uuid);
        $this->assertEquals(1, $eBuilding->is_deleted);
    }
}