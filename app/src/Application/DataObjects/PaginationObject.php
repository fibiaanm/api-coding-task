<?php

namespace App\Application\DataObjects;

use Slim\Psr7\Request;
use OpenApi\Attributes as OA;

#[OA\Parameter(
    parameter: 'PageParameter',
    name: 'page',
    description: 'Page number for pagination',
    in: 'query',
    required: false,
    schema: new OA\Schema(type: 'integer', example: 1)
)]
#[OA\Parameter(
    parameter: 'LimitParameter',
    name: 'limit',
    description: 'Number of items per page',
    in: 'query',
    required: false,
    schema: new OA\Schema(type: 'integer', example: 10)
)]
class PaginationObject
{

    public function __construct(
        public int $page,
        public int $limit,
        public int $total = 0,
    ) {

    }

    public function getOffset(): int
    {
        return ($this->page - 1) * $this->limit;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    public function isNextPage(): bool
    {
        return $this->total === $this->limit;
    }

    public function buildNextPageLink(Request $request): string
    {
        if (!$this->isNextPage()) {
            return '';
        }
        $nextPage = $this->page + 1;
        $baseUrl = $request->getUri()->getScheme() . '://' . $request->getUri()->getHost();
        $baseUrl .= $request->getUri()->getPath();
        $queryParams = [
            'page' => $nextPage,
            'limit' => $this->limit
        ];
        return $baseUrl . '?' . http_build_query($queryParams);
    }

}