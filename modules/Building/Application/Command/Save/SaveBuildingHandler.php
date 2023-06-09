<?php

namespace TP\Building\Application\Command\Save;


use TP\Building\Application\Services\GetBuildingByIdService;
use TP\Building\Domain\Building;
use TP\Building\Domain\BuildingEventState;
use TP\Building\Domain\BuildingRepository;
use TP\Building\Domain\Exceptions\ErrorOnSaveBuildingException;
use TP\Building\Domain\Exceptions\NotFoundBuildingException;
use TP\Building\Domain\VO\BuildingType;
use TP\Shared\VO\Address;
use TP\Shared\VO\City;
use TP\Shared\VO\Id;
use TP\Shared\VO\Name;
use TP\Shared\VO\PostalCode;
use TP\Shared\VO\StringValue;

final readonly class SaveBuildingHandler
{
    public function __construct(
        private BuildingRepository $buildingRepository,
        private GetBuildingByIdService $buildingByIdService
    )
    {
    }

    /**
     * @param SaveBuildingCommand $command
     * @return SaveBuildingResponse
     * @throws NotFoundBuildingException
     */
    public function handle(SaveBuildingCommand $command): SaveBuildingResponse
    {
        $response = new SaveBuildingResponse();

        $name = new Name($command->name());
        $address = new Address($command->address());
        $postalCode = new PostalCode($command->postalCode());
        $city = new City($command->city());
        $type = new BuildingType($command->type());
        $description = $command->description() ? new StringValue($command->description()): null;
        $id = $command->id() ? new Id($command->id()) : null;

        $this->checkIfBuildingExistOrThrowNotFoundException($id);

        $building = Building::create(
            $name,
            $address,
            $postalCode,
            $city,
            $type,
            $description,
            $id
        );

        try {
            $building->defineBuildingEventState(BuildingEventState::onSave);
            $this->buildingRepository->save($building);
            $response->isSaved = true;
            $response->message = "Immeuble enregistré avec succès.";
            $response->id = $building->id()->value();
        } catch (ErrorOnSaveBuildingException $e) {
            $response->message = $e->getMessage();
        }

        return $response;
    }

    /**
     * @param Id|null $id
     * @return void
     * @throws NotFoundBuildingException
     */
    private function checkIfBuildingExistOrThrowNotFoundException(?Id $id): void
    {
        if ($id) {
            $this->buildingByIdService->execute($id);
        }
    }

}
