<?php

namespace Module\Shared\VO;

class RandomString
{
    private int $length;
    private string $value;

    public function __construct(int $length) {
        $this->length = $length;
    }

    public function value() {

    }
}
