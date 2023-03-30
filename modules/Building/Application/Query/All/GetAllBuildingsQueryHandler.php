<?php

namespace TP\Building\Application\Query\All;


use TP\Shared\Lib\Database\PdoConnection;

final readonly class GetAllBuildingsQueryHandler
{

    public function __construct(private PdoConnection $connection)
    {
    }

    /**
     * @param string $companyId
     * @return GetAllBuildingsQueryResponse
     */
    public function handle(string $companyId): GetAllBuildingsQueryResponse
    {
        $response = new GetAllBuildingsQueryResponse();
        $sql = "
            SELECT
                uuid as id,
                name,
                address_line1 as address,
                postal_code as postalCode,
                city
            FROM buildings
            WHERE
                is_deleted = false AND
                company_uuid = :uuid
        ";
        $st = $this->connection->getPdo()->prepare($sql);
        $st->bindParam('uuid', $companyId);
        $st->setFetchMode(\PDO::FETCH_CLASS, BuildingDto::class);
        $st->execute();
        $response->buildings = $st->fetchAll();

        return $response;
    }
}
