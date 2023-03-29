<?php

namespace TP\Shared\Application\City\Query;


class FindByPostalCodeQueryHandler
{
    public function __construct(private PdoConnexion $connexion)
    {
    }

    public function handle(string $postalCode): ?CityQueryResponse
    {
        $st = $this->connexion->getPdo()->prepare(
            "SELECT code_postal, libelle FROM code_postals WHERE code_postal = ?",
        );
        $st->execute([$postalCode]);
        $result = $st->fetch(\PDO::FETCH_OBJ);
        if (!$result) {
            return null;
        }

        $city = new CityQueryResponse();
        $city->name = $result->libelle;
        $city->postalCode = $result->code_postal;
        return $city;
    }
}
