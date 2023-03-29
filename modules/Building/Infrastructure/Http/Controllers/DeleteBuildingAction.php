<?php

namespace Module\Infrastructure\Building\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\Application\Building\Command\Delete\DeleteBuildingHandler;
use Module\Domain\Building\Exceptions\NotFoundBuildingException;

class DeleteBuildingAction
{

    /**
     * @param Request $request
     * @param DeleteBuildingHandler $handler
     * @return JsonResponse
     */
    public function __invoke(
        Request               $request,
        DeleteBuildingHandler $handler
    ): JsonResponse
    {
        $httpJson = [
            'isDeleted' => false,
            'message'   => "Veuillez entrer l'immeuble à supprimer !"
        ];

        if (!$request->get('id')) {
            return response()->json($httpJson);
        }

        try {
            $response = $handler->handle($request->get('id'));
            $httpJson['isDeleted'] = $response->isDeleted;
            $httpJson['message'] = $response->message;
        } catch (NotFoundBuildingException|\Exception $e) {
            $httpJson['message'] = $e->getMessage();
        }

        return response()->json($httpJson);
    }
}