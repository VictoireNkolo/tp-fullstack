<?php

namespace Module\Infrastructure\Building\Repositories;

use Illuminate\Support\Facades\DB;
use Module\Domain\Building\Building;
use Module\Domain\Building\BuildingRepository;
use Module\Domain\Building\BuildingEventState;
use Module\Domain\Building\Exceptions\ErrorOnSaveBuildingException;
use Module\Infrastructure\Building\Models\Building as BuildingModel;
use Module\Shared\VO\Id;

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