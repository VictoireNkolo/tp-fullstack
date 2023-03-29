<?php

namespace TP\Building\Application\Services;


use TP\Building\Domain\Building;
use TP\Building\Domain\BuildingRepository;
use TP\Building\Domain\Exceptions\NotFoundBuildingException;
use TP\Shared\VO\Id;

readonly class GetBuildingByIdService
{

    public function __construct(
        private BuildingRepository $repository
    ) {
    }

    /**
     * @throws NotFoundBuildingException
     */
    public function execute(Id $id): Building
    {
        $building = $this->repository->byId($id);
        if(!$building) {
            throw new NotFoundBuildingException("Cet immeuble n'existe pas !");
        }
        return $building;
    }
}
