<?php

namespace App\Application\DataObjects;

use Slim\Psr7\Request;

class PaginationObject
{

    public function __construct(
        public int $page,
        public int $limit,
        public int $total = 0,
    )
    {
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