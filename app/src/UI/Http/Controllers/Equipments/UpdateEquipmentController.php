<?php

namespace App\UI\Http\Controllers\Equipments;

use App\Application\Services\EquipmentService;
use App\Infrastructure\Exceptions\EquipmentNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class UpdateEquipmentController
{

    public function __construct(
        private readonly EquipmentService $equipmentService
    )
    {
    }

    public function __invoke(
        Request $request,
        Response $response,
        $args
    ): Response
    {
        try {
            $bodyEncoded = $request->getBody();
            $body = json_decode($bodyEncoded, true);
            $equipment = $this->equipmentService->update($args['id'], $body);
            return ResponseBuilder::success($equipment->toArray());
        } catch (EquipmentNotFoundException $e) {
            return ResponseBuilder::notFound($e->getMessage());
        } catch (\Exception $e) {
            return ResponseBuilder::serverError($e->getMessage());
        }
    }

}