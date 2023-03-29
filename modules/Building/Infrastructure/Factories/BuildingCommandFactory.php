<?php

namespace Module\Infrastructure\Building\Factories;

use Module\Application\Building\Command\Save\SaveBuildingCommand;
use Module\Domain\Exceptions\InvalidCommandException;
use Module\Infrastructure\Building\Http\Requests\SaveBuildingRequest;

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
            $request->get('company_id'),
            $request->get('name'),
            $request->get('address'),
            $request->get('postal_code'),
            $request->get('city'),
            $request->get('id')
        );
    }

}