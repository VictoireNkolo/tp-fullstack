<?php

namespace TP\Building\Application\Command\Delete;


use TP\Building\Application\Services\GetBuildingByIdService;
use TP\Building\Domain\BuildingEventState;
use TP\Building\Domain\BuildingRepository;
use TP\Building\Domain\Exceptions\ErrorOnSaveBuildingException;
use TP\Building\Domain\Exceptions\NotFoundBuildingException;
use TP\Shared\VO\Id;

final readonly class DeleteBuildingHandler
{

    public function __construct(
        private BuildingRepository $buildingRepository,
        private GetBuildingByIdService $getBuildingByIdServiceOrThrowException
    )
    {
    }

    /**
     * @throws NotFoundBuildingException
     */
    public function handle(string $id): DeleteBuildingResponse
    {
        $response = new DeleteBuildingResponse();
        $building = $this->getBuildingByIdServiceOrThrowException->execute(new Id($id));
        $building->defineBuildingEventState(BuildingEventState::onDelete);
        try {
            $this->buildingRepository->save($building);
            $response->isDeleted = true;
            $response->message = "Immeuble supprimé avec succès.";
        } catch (ErrorOnSaveBuildingException $e) {
            $response->message = $e->getMessage();
        }
        return $response;
    }
}
