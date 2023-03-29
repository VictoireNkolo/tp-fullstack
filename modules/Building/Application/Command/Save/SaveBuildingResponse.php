<?php

namespace TP\Building\Application\Command\Save;

class SaveBuildingResponse
{
    public bool $isSaved = false;
    public string $message = '';
    public ?string $id = null;
}
