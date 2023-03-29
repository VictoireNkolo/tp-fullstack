<?php

namespace Module\Shared\VO;

use InvalidArgumentException;

class PostalCode extends StringValue
{

    public function __construct(?string $value) {
        if (!$value) {
            throw new InvalidArgumentException("Le code postal entré n'est pas valide");
        }
        parent::__construct($value);
    }

}
