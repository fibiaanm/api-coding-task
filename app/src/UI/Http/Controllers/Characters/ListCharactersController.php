<?php

namespace App\UI\Http\Controllers\Characters;

use App\Application\DataObjects\PaginationObject;
use App\Application\Services\CharacterService;
use App\Infrastructure\Exceptions\CharactersNotFoundException;
use App\UI\Http\Responses\ResponseBuilder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ListCharactersController
{
    public function __construct(
        private readonly CharacterService $characterService
    )
    {
    }

    public function __invoke(Request $request, Response $response, $args): Response
    {
        try {
            $page = $request->getQueryParams()['page'] ?? 1;
            $limit = $request->getQueryParams()['limit'] ?? 10;
            $pagination = new PaginationObject($page, $limit);

            $characters = $this->characterService->list($pagination);
            return ResponseBuilder::success([
                'next_page' => $pagination->buildNextPageLink($request),
                'characters' => $characters->toArray()
            ]);
        } catch (CharactersNotFoundException $e) {
            return ResponseBuilder::notFound('Characters not found');
        } catch (\Exception $e) {
            return ResponseBuilder::serverError($e->getMessage());
        }
    }

}