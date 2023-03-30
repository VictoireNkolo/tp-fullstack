<?php

namespace TP\Building\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use TP\Building\Application\Command\Save\SaveBuildingHandler;
use TP\Building\Domain\Exceptions\NotFoundBuildingException;
use TP\Building\Infrastructure\Factories\BuildingCommandFactory;
use TP\Building\Infrastructure\Http\Requests\SaveBuildingRequest;
use TP\Shared\Exceptions\InvalidCommandException;

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
            'id'      => null
        ];

        try {
            $command = BuildingCommandFactory::buildCommandFromRequest($request);
            $response = $handler->handle($command);
            $httpJson['isSaved'] = $response->isSaved;
            $httpJson['message'] = $response->message;
            $httpJson['id'] = $response->id;
        } catch (
            InvalidCommandException|
            NotFoundBuildingException|
        \Exception $e
        ) {
            $httpJson['message'] = $e->getMessage();
        }

        return response()->json($httpJson);
    }
}
