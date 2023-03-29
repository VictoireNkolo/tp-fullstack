<?php

namespace TP\Building\Application\Command\Delete;


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
