<?php

namespace Module\Infrastructure\Building\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Module\Application\Building\Command\Save\SaveBuildingHandler;
use Module\Domain\Building\Exceptions\NotFoundBuildingException;
use Module\Domain\Company\Exception\NotFoundCompanyException;
use Module\Domain\Exceptions\InvalidCommandException;
use Module\Infrastructure\Building\Factories\BuildingCommandFactory;
use Module\Infrastructure\Building\Http\Requests\SaveBuildingRequest;

class SaveBuildingAction
{

    /**
     * @param SaveBuildingRequest $request
     * @param SaveBuildingHandler $handler
     * @return JsonResponse
     */
    public function __invoke(
        SaveBuildingRequest $request,
        SaveBuildingHandler $handler
    ): JsonResponse
    {
        $httpJson = [
            'isSaved' => false,
            'message' => '',
            'id' => null
        ];

        try {
            $command = BuildingCommandFactory::buildCommandFromRequest($request);
            $response = $handler->handle($command);
            $httpJson['isSaved'] = $response->isSaved;
            $httpJson['message'] = $response->message;
            $httpJson['id'] = $response->id;
        } catch (
            InvalidCommandException|
            NotFoundCompanyException|
            NotFoundBuildingException|
            \Exception $e
        ) {
            $httpJson['message'] = $e->getMessage();
        }

        return response()->json($httpJson);
    }
}