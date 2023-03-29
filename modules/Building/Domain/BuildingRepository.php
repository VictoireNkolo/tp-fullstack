<?php

namespace TP\Building\Domain;


use TP\Building\Domain\Exceptions\ErrorOnSaveBuildingException;
use TP\Shared\VO\Id;

interface BuildingRepository
{
    public function byId(Id $id): ?Building;

    /**
     * @throws ErrorOnSaveBuildingException
     */
    public function save(Building $building): void;
}
