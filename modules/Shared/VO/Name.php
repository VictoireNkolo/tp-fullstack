<?php

namespace TP\Shared\VO;

use InvalidArgumentException;

class Name extends StringValue
{

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string $value
    ) {
        if ($value == null) {
            throw new InvalidArgumentException("Veuillez entrer le nom");
        }
        parent::__construct($value);
    }
}
