<?php

namespace TP\Building\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use TP\Building\Application\Query\All\GetAllBuildingsQueryHandler;
use TP\Building\Infrastructure\viewModels\BuildingsViewModel;

class GetAllBuildingsAction
{

    /**
     * @param string $companyId
     * @param GetAllBuildingsQueryHandler $queryHandler
     * @return JsonResponse
     */
    public function __invoke(
        string                      $companyId,
        GetAllBuildingsQueryHandler $queryHandler
    ): JsonResponse
    {
        $httpJson = ['status' => false, 'buildings' => []];
        if (!$companyId) {
            return response()->json($httpJson);
        }

        $response = $queryHandler->handle($companyId);
        if (!$response->buildings) {
            return response()->json($httpJson);
        }
        $viewModel = new BuildingsViewModel($response);
        $httpJson['buildings'] = $viewModel->toArray();
        $httpJson['status'] = true;

        return response()->json($httpJson);
    }
}
