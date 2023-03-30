<?php

namespace TP\Building\Domain\VO;

use InvalidArgumentException;
use TP\Shared\VO\StringValue;

class BuildingType extends StringValue
{

    /**
     * @param string $value
     *
     * @throws InvalidArgumentException
     */
    public function __construct(private readonly string $value)
    {
        parent::__construct($value);
        $this->validate();
    }

    /**
     * @return void
     *
     * @throws InvalidArgumentException
     */
    private function validate(): void
    {
        if (!in_array($this->value, ['Maison', 'Appartement', 'Parking'])) {
            throw new InvalidArgumentException("veuillez sélectionner un type valide");
        }
    }
}
