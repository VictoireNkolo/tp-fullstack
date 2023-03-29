<?php

namespace TP\Building\Domain;


use TP\Shared\VO\Address;
use TP\Shared\VO\City;
use TP\Shared\VO\Id;
use TP\Shared\VO\Name;
use TP\Shared\VO\PostalCode;

final class Building
{

    private BuildingEventState $buildingEventState;

    /**
     * @param Id $id
     * @param Name $name
     * @param Address $address
     * @param PostalCode $postalCode
     * @param City $city
     */
    private function __construct(
        private Id         $id,
        private Name       $name,
        private Address    $address,
        private PostalCode $postalCode,
        private City       $city
    )
    {
    }

    /**
     * @param Name $name
     * @param Address $address
     * @param PostalCode $postalCode
     * @param City $city
     * @param Id|null $id
     * @return self
     */
    public static function create(
        Name       $name,
        Address    $address,
        PostalCode $postalCode,
        City       $city,
        ?Id        $id
    ): self
    {
        return new self(
            $id ?: new Id(),
            $name,
            $address,
            $postalCode,
            $city
        );
    }

    public function defineBuildingEventState(BuildingEventState $state): void
    {
        $this->buildingEventState = $state;
    }

    public function buildingState(): BuildingEventState
    {
        return $this->buildingEventState;
    }

    /**
     * @return Id
     */
    public function id(): Id
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function name(): Name
    {
        return $this->name;
    }

    /**
     * @return Address
     */
    public function address(): Address
    {
        return $this->address;
    }

    /**
     * @return PostalCode
     */
    public function postalCode(): PostalCode
    {
        return $this->postalCode;
    }

    /**
     * @return City
     */
    public function city(): City
    {
        return $this->city;
    }

    public function toArray(): array
    {
        $data =  [
            'uuid' => $this->id->value(),
            'name' => $this->name->value(),
            'city' => $this->city->value(),
            'postal_code' => $this->postalCode->value(),
            'address_line1' => $this->address->value()
        ];

        if ($this->buildingEventState === BuildingEventState::onDelete) {
            $data['is_deleted'] = true;
        }

        return $data;
    }

}
