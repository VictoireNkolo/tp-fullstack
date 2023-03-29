<?php

namespace TP\Shared\VO;

use Ramsey\Uuid\Uuid;

class Id implements IdGenerator
{
    private string $id;

    public function __construct(?string $uuid = null)
    {
        $this->id = $uuid ?: Uuid::uuid4()->toString();
    }

    public function value(): string
    {
        return $this->id;
    }

    public function generate($value = null): string
    {
        return $this->id;
    }
}
