<?php

namespace TP\Shared\VO;

use InvalidArgumentException;

class Label extends StringValue
{

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string $value
    ) {
        if ($value == null) {
            throw new InvalidArgumentException("Veuillez entrer le libellé de l'opération");
        }
        parent::__construct($value);
    }
}
