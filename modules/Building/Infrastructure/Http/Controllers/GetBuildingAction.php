<?php

namespace TP\Building\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use TP\Building\Application\Query\Get\GetBuildingQueryHandler;
use TP\Building\Infrastructure\viewModels\BuildingViewModel;

class GetBuildingAction
{

    /**
     * @param string $id
     * @param GetBuildingQueryHandler $queryHandler
     * @return JsonResponse
     */
    public function __invoke(
        string                  $id,
        GetBuildingQueryHandler $queryHandler
    ): JsonResponse
    {
        $httpJson = ['status' => false, 'building' => []];
        if (!$id) {
            return response()->json($httpJson);
        }

        $response = $queryHandler->handle($id);
        if (!$response->building) {
            return response()->json($httpJson);
        }
        $viewModel = new BuildingViewModel($response);
        $httpJson['building'] = $viewModel->toArray();
        $httpJson['status'] = true;

        return response()->json($httpJson);
    }
}
