<?php

namespace TP\Building\Application\Query\Get;


use TP\Shared\Lib\Database\PdoConnection;

final readonly class GetBuildingQueryHandler
{

    public function __construct(private PdoConnection $connection)
    {
    }

    /**
     * @param string $id
     * @return GetBuildingQueryResponse
     */
    public function handle(string $id): GetBuildingQueryResponse
    {
        $response = new GetBuildingQueryResponse();
        $sql = "
            SELECT
                   uuid as id,
                   name,
                   address_line1 as address,
                   postal_code as postalCode,
                   city
            FROM buildings
            WHERE is_deleted = false AND
                  uuid = ?
        ";
        $st = $this->connection->getPdo()->prepare($sql);
        $st->execute([$id]);
        $result = $st->fetch(\PDO::FETCH_OBJ);

        if ($result) {
            $response->building = $this->hydrate($result);
        }

        return $response;
    }

    private function hydrate(mixed $result): BuildingDto
    {
        $building = new BuildingDto();
        $building->id = $result->id;
        $building->name = $result->name;
        $building->address = $result->address;
        $building->postalCode = $result->postalCode;
        $building->city = $result->city;

        return $building;
    }
}
