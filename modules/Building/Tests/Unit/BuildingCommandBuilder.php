<?php

namespace TP\Building\Tests\Unit;

use TP\Building\Application\Command\Save\SaveBuildingCommand;
use TP\Shared\Exceptions\InvalidCommandException;

class BuildingCommandBuilder
{

    private string $name = 'Immeuble Test';
    private string $address = 'Rue 1465, Etoug-Ebe, Yaoundé';
    private string $postalCode = '01234';
    private string $city = 'Yaoundé';
    private string $type = 'Appartement';
    private ?string $description = null;
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
            $this->name,
            $this->address,
            $this->postalCode,
            $this->city,
            $this->type,
            $this->description,
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
