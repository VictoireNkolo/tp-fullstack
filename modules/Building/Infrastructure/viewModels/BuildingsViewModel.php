<?php

namespace TP\Building\Infrastructure\viewModels;


use TP\Building\Application\Query\All\GetAllBuildingsQueryResponse;
use TP\Building\Application\Query\BuildingDto;

readonly class BuildingsViewModel
{

    public function __construct(private GetAllBuildingsQueryResponse $response)
    {
    }

    public function toArray(): array
    {
        return array_map(function (BuildingDto $dto) {
            return [
                'id'          => $dto->id,
                'name'        => $dto->name,
                'address'     => $dto->address,
                'city'        => $dto->city,
                'postal_code' => $dto->postalCode,
                'type'        => $dto->type,
                'description' => $dto->description
            ];
        }, $this->response->buildings);
    }
}
