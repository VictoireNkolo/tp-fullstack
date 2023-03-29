<?php

namespace TP\Building\Tests\Unit;

use TP\Building\Application\Command\Save\SaveBuildingCommand;

class BuildingCommandBuilder
{

    private string $companyId = '001';
    private string $name = 'Immeuble Test';
    private string $address = 'Rue 1465, Etoug-Ebe, Yaoundé';
    private string $postalCode = '01234';
    private string $city = 'Yaoundé';
    private ?string $id = null;

    public static function asBuilder(): self
    {
        return new self();
    }

    /**
     * @throws InvalidCommandException
     */
    public function build(): SaveBuildingCommand
    {
        return new SaveBuildingCommand(
            $this->companyId,
            $this->name,
            $this->address,
            $this->postalCode,
            $this->city,
            $this->id
        );
    }

    public function withId(string $value): self
    {
        $this->id = $value;
        return $this;
    }

    public function withName(string $value): self
    {
        $this->name = $value;
        return $this;
    }

    public function withAddress(string $value): self
    {
        $this->address = $value;
        return $this;
    }

    public function withCity(string $value): self
    {
        $this->city = $value;
        return $this;
    }
}
