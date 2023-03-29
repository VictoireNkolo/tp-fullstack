<?php

namespace TP\Shared\VO;

use InvalidArgumentException;

class Address extends StringValue
{
    private string $postalCode;
    private string $city;

    /**
     * @param string|null $address
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string $address
    ) {
        $this->isValid($address);
        parent::__construct($address);
    }


    /**
     * @param string|null $value
     * @throws InvalidArgumentException
     * @return void
     */
    private function isValid(?string $value): void
    {
        if (!$value) {
            throw new InvalidArgumentException("L'adresse entrée n'est pas valide");
        }
    }


    public function changePostalCode(string $postalCode) {
        $this->postalCode = $postalCode;
    }

    public function changeCity(string $city) {
        $this->city = $city;
    }

}
