<?php

namespace TP\Shared\VO;

interface IdGenerator
{
    public function generate($value = null): string;
}
