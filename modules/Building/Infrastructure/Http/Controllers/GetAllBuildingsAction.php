<?php

namespace Module\Infrastructure\Building\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Module\Application\Building\Query\All\GetAllBuildingsQueryHandler;
use Module\Infrastructure\Building\viewModels\BuildingsViewModel;

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