<?php

namespace Module\Infrastructure\Building\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Module\Application\Building\Query\Get\GetBuildingQueryHandler;
use Module\Infrastructure\Building\viewModels\BuildingViewModel;

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