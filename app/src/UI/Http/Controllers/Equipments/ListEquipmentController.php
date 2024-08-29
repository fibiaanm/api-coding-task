<?php

namespace App\UI\Http\Controllers\Equipments;


use App\Application\DataObjects\PaginationObject;
use App\Application\Services\EquipmentService;
use App\Infrastructure\Exceptions\EquipmentsNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ListEquipmentController
{
    public function __construct(
        private readonly EquipmentService $equipmentService
    )
    {
    }

    public function __invoke(
        Request $request,
        Response $response,
    ): Response
    {
        try {
            $page = $request->getQueryParams()['page'] ?? 1;
            $limit = $request->getQueryParams()['limit'] ?? 10;
            $pagination = new PaginationObject($page, $limit);
            $equipments = $this->equipmentService->list($pagination);
            return ResponseBuilder::success([
                'next_page' => $pagination->buildNextPageLink($request),
                'equipment' => $equipments->toArray()
            ]);
        } catch (EquipmentsNotFoundException $e) {
            return ResponseBuilder::notFound($e->getMessage());
        } catch (\Exception $e) {
            return ResponseBuilder::serverError($e->getMessage());
        }
    }

}