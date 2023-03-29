<?php

namespace TP\Shared\VO;

use InvalidArgumentException;

class Country extends StringValue
{


    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string $value
    ) {
        if ($value == null) {
            throw new InvalidArgumentException("Le pays entré n'est pas valide");
        }
        parent::__construct($value);
    }

}
