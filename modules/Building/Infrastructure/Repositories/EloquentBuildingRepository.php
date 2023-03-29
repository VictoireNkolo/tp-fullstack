<?php

namespace TP\Building\Infrastructure\Repositories;

use TP\Building\Domain\Building;
use TP\Building\Domain\BuildingRepository;
use TP\Building\Domain\Exceptions\ErrorOnSaveBuildingException;
use TP\Building\Infrastructure\Models\Building as BuildingModel;
use TP\Shared\VO\Id;

class EloquentBuildingRepository implements BuildingRepository
{

    public function byId(Id $id): ?Building
    {
        return BuildingModel::whereUuid($id->value())
            ->whereIsDeleted(false)
            ->first()?->toDomain();
    }

    /**
     * @throws ErrorOnSaveBuildingException
     */
    public function save(Building $building): void
    {
        $eBuilding = BuildingModel::whereUuid($building->id()->value())
            ->whereIsDeleted(false)
            ->first();
        if (!$eBuilding) {
            $eBuilding = new BuildingModel();
        }
        try {
            $eBuilding->fill($building->toArray())->save();
        } catch (\Throwable|\Exception $e) {
            throw new ErrorOnSaveBuildingException($e->getMessage());
        }
    }
}
