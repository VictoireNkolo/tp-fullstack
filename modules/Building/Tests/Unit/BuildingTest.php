<?php

namespace TP\Building\Tests\Unit;


use Tests\TestCase;
use TP\Building\Application\Command\Save\SaveBuildingCommand;
use TP\Building\Application\Command\Save\SaveBuildingHandler;
use TP\Building\Application\Command\Save\SaveBuildingResponse;
use TP\Building\Application\Services\GetBuildingByIdService;
use TP\Building\Domain\Building;
use TP\Building\Domain\Exceptions\NotFoundBuildingException;
use TP\Shared\Exceptions\InvalidCommandException;
use TP\Shared\VO\Address;
use TP\Shared\VO\City;
use TP\Shared\VO\Id;
use TP\Shared\VO\Name;
use TP\Shared\VO\PostalCode;

class BuildingTest extends TestCase
{

    private InMemoryBuildingRepository $buildingRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->buildingRepository = new InMemoryBuildingRepository();
    }

    /**
     * @throws InvalidCommandException
     * @throws NotFoundBuildingException
     */
    public function test_can_create_a_building()
    {
        $saveBuildingCommand = BuildingCommandBuilder::asBuilder()
            ->build();

        $response = $this->saveBuilding($saveBuildingCommand);

        $this->assertTrue($response->isSaved);
        $this->assertNotNull($response->id);
    }

    /**
     * @throws NotFoundBuildingException
     * @throws InvalidCommandException
     * @throws NotFoundCompanyException
     */
    public function test_can_update_existing_building()
    {
        $building = $this->buildSUT();
        $saveBuildingCommand = BuildingCommandBuilder::asBuilder()
            ->withId($building->id()->value())
            ->build();

        $response = $this->saveBuilding($saveBuildingCommand);

        $this->assertTrue($response->isSaved);
        $this->assertNotNull($response->id);
    }

    /**
     * @throws InvalidCommandException
     * @throws NotFoundCompanyException
     */
    public function test_can_throw_not_found_building_exception()
    {
        $building = $this->buildSUT();
        $saveBuildingCommand = BuildingCommandBuilder::asBuilder()
            ->withCompanyId($building->companyId()->value())
            ->withId('5456')
            ->build();

        $this->expectException(NotFoundBuildingException::class);
        $this->saveBuilding($saveBuildingCommand);
    }

    public function test_can_throw_invalid_command_exception()
    {
        $this->expectException(InvalidCommandException::class);
        BuildingCommandBuilder::asBuilder()
            ->withCompanyId('')
            ->withName('')
            ->withAddress('')
            ->withCity('')
            ->build();
    }

    /**
     * @throws NotFoundBuildingException
     */
    public function test_can_delete_existing_building()
    {
        $building = $this->buildSUT();
        $buildingById = new GetBuildingByIdService($this->buildingRepository);
        $deleteBuildingHandler = new DeleteBuildingHandler($this->buildingRepository, $buildingById);
        $response = $deleteBuildingHandler->handle($building->id()->value());

        $this->assertTrue($response->isDeleted);
    }

    private function buildSUT(): Building
    {
        $building = Building::create(
            new Name('Immeuble Test'),
            new Address('Biyem-Assi, Yaoundé'),
            new PostalCode('12345'),
            new City('Yaoundé'),
            new Id()
        );
        $this->buildingRepository->buildings[] = $building;
        return $building;
    }

    /**
     * @param SaveBuildingCommand $saveBuildingCommand
     * @return SaveBuildingResponse
     * @throws NotFoundBuildingException
     */
    private function saveBuilding(SaveBuildingCommand $saveBuildingCommand): SaveBuildingResponse
    {
        $buildingById = new GetBuildingByIdService($this->buildingRepository);
        $saveBuildingHandler = new SaveBuildingHandler(
            $this->buildingRepository,
            $buildingById
        );
        return $saveBuildingHandler->handle($saveBuildingCommand);
    }

}
