<?php

namespace TP\Building\Tests\Unit;

use TP\Building\Domain\Building;
use TP\Building\Domain\BuildingRepository;
use TP\Shared\VO\Id;

class InMemoryBuildingRepository implements BuildingRepository
{

    /**
     * @var Building[]
     */
    public array $buildings = [];

    public function byId(Id $id): ?Building
    {
        $building = array_values(
            array_filter(
                $this->buildings,
                fn(Building $b) => $b->id()->value() === $id->value()
            )
        );
        if (!empty($building)) {
            return $building[0];
        }
        return null;
    }

    public function save(Building $building): void
    {
        $this->buildings[] = $building;
    }
}
