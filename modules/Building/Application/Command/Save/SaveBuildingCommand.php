<?php

namespace TP\Building\Application\Command\Save;


use TP\Shared\Exceptions\InvalidCommandException;

readonly class SaveBuildingCommand
{

    /**
     * @throws InvalidCommandException
     */
    public function __construct(
        private string $name,
        private string $address,
        private string $postalCode,
        private string $city,
        private ?string $id,
    )
    {
        $this->validate();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function address(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function postalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function city(): string
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function id(): ?string
    {
        return $this->id;
    }

    /**
     * @throws InvalidCommandException
     */
    private function validate(): void
    {
        if (
            !$this->name ||
            !$this->address ||
            !$this->postalCode ||
            !$this->city
        ) {
            throw new InvalidCommandException("veuillez renseigner toutes les données de l'immeuble");
        }
    }
}
