<?php

namespace TP\Building\Infrastructure\viewModels;


use TP\Building\Application\Query\Get\GetBuildingQueryResponse;

readonly class BuildingViewModel
{

    public function __construct(private GetBuildingQueryResponse $response)
    {
    }

    public function toArray(): array
    {
        return [
            'id'          => $this->response->building->id,
            'name'        => $this->response->building->name,
            'address'     => $this->response->building->address,
            'city'        => $this->response->building->city,
            'postal_code' => $this->response->building->postalCode,
            'type'        => $this->response->building->type,
            'description' => $this->response->building->description
        ];
    }
}
