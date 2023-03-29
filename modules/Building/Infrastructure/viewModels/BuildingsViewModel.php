<?php

namespace Module\Infrastructure\Building\viewModels;

use Module\Application\Building\Query\All\GetAllBuildingsQueryResponse;
use Module\Application\Building\Query\BuildingDto;

readonly class BuildingsViewModel
{

    public function __construct(private GetAllBuildingsQueryResponse $response)
    {
    }

    public function toArray(): array
    {
        return array_map(function ($dto) {
            return [
                'id' => $dto->id,
                'name' => $dto->name,
                'address' => $dto->address,
                'city' => $dto->city,
                'postal_code' => $dto->postalCode
            ];
        }, $this->response->buildings);
    }
}