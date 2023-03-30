<?php

namespace TP\Building\Infrastructure\Factories;


use TP\Building\Application\Command\Save\SaveBuildingCommand;
use TP\Building\Infrastructure\Http\Requests\SaveBuildingRequest;
use TP\Shared\Exceptions\InvalidCommandException;

class BuildingCommandFactory
{

    /**
     * @throws InvalidCommandException
     */
    public static function buildCommandFromRequest(
        SaveBuildingRequest $request
    ): SaveBuildingCommand
    {
        return new SaveBuildingCommand(
            $request->get('name'),
            $request->get('address'),
            $request->get('postal_code'),
            $request->get('city'),
            $request->get('id')
        );
    }

}
