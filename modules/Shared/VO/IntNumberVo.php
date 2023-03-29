<?php

namespace TP\Shared\VO;

use InvalidArgumentException;

class IntNumberVo
{
    /**
     * @param int|null $value
     * @throws InvalidArgumentException
     */
    public function __construct(private ?int $value) {
        $this->validate();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function add(int $value): self
    {
        $value = new static($value);
        $this->value += $value->value();
        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function sub(int $value): self
    {
        $value = new static($value);
        $this->value -= $value->value();
        return $this;
    }

    public function value(): int
    {
        return $this->value;
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    private function validate() :void
    {
        if (is_null($this->value) || !in_array(gettype((int) $this->value), ['integer', 'numeric'])) {
            throw new InvalidArgumentException("Nombre entré non valide");
        }
    }
}
