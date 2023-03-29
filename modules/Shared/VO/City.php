<?php

namespace TP\Shared\VO;

use InvalidArgumentException;

class City extends StringValue
{

    /**
     * @param string|null $value
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string $value
    ) {
        if ($value == null) {
            throw new InvalidArgumentException("La ville entrée n'est pas valide");
        }
        parent::__construct($value);
    }
}
