<?php

namespace TP\Building\Application\Query\All;


use TP\Building\Application\Query\BuildingDto;
use TP\Shared\Lib\Database\PdoConnection;

final readonly class GetAllBuildingsQueryHandler
{

    public function __construct(private PdoConnection $connection)
    {
    }

    /**
     * @return GetAllBuildingsQueryResponse
     */
    public function handle(): GetAllBuildingsQueryResponse
    {
        $response = new GetAllBuildingsQueryResponse();
        $sql = "
            SELECT
                uuid as id,
                name,
                address,
                postal_code as postalCode,
                city,
                type,
                description
            FROM buildings
            WHERE
                is_deleted = false
        ";
        $response->buildings = $this->connection->getPdo()->query(
            "$sql",
            \PDO::FETCH_CLASS,
            BuildingDto::class
        )->fetchAll();

        return $response;
    }
}
