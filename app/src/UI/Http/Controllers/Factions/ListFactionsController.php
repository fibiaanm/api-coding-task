<?php

namespace App\UI\Http\Controllers\Factions;

use App\Application\DataObjects\PaginationObject;
use App\Application\Services\FactionsService;
use App\Infrastructure\Exceptions\FactionsNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ListFactionsController
{

    function __construct(
        private FactionsService $factionsService
    )
    {

    }

    public function __invoke(Request $request, Response $response): Response
    {
        try {
            $page = $request->getQueryParams()['page'] ?? 1;
            $limit = $request->getQueryParams()['limit'] ?? 10;
            $pagination = new PaginationObject($page, $limit);

            $factions = $this->factionsService->list($pagination);

            // Return the response with factions and next page link
            return ResponseBuilder::success([
                'next_page' => $pagination->buildNextPageLink($request),
                'factions' => $factions->toArray(),
            ]);
        } catch (FactionsNotFoundException $e) {
            return ResponseBuilder::notFound('Factions not found');
        } catch (\Exception $e) {
            return ResponseBuilder::serverError('Internal server error');
        }
    }

}