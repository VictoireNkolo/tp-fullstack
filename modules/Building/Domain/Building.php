<?php

namespace TP\Building\Domain;


use TP\Building\Domain\VO\BuildingType;
use TP\Shared\VO\Address;
use TP\Shared\VO\City;
use TP\Shared\VO\Id;
use TP\Shared\VO\Name;
use TP\Shared\VO\PostalCode;
use TP\Shared\VO\StringValue;

final class Building
{

    private BuildingEventState $buildingEventState;

    /**
     * @param Id $id
     * @param Name $name
     * @param Address $address
     * @param PostalCode $postalCode
     * @param City $city
     * @param BuildingType $type
     * @param StringValue|null $description
     */
    private function __construct(
        private Id           $id,
        private Name         $name,
        private Address      $address,
        private PostalCode   $postalCode,
        private City         $city,
        private BuildingType $type,
        private ?StringValue $description
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
        Name         $name,
        Address      $address,
        PostalCode   $postalCode,
        City         $city,
        BuildingType $type,
        ?StringValue $description,
        ?Id          $id
    ): self
    {
        return new self(
            $id ?: new Id(),
            $name,
            $address,
            $postalCode,
            $city,
            $type,
            $description
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

    /**
     * @return BuildingType
     */
    public function type(): BuildingType
    {
        return $this->type;
    }

    /**
     * @return StringValue|null
     */
    public function description(): ?StringValue
    {
        return $this->description;
    }

    public function toArray(): array
    {
        $data = [
            'uuid'        => $this->id->value(),
            'name'        => $this->name->value(),
            'address'     => $this->address->value(),
            'postal_code' => $this->postalCode->value(),
            'city'        => $this->city->value(),
            'type'        => $this->type->value(),
            'description' => $this->description?->value()
        ];

        if ($this->buildingEventState === BuildingEventState::onDelete) {
            $data['is_deleted'] = true;
        }

        return $data;
    }

}
