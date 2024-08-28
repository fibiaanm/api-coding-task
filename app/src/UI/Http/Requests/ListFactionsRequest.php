<?php

namespace App\UI\Http\Requests;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Slim\Psr7\Interfaces\HeadersInterface;
use Slim\Psr7\Request;

class ListFactionsRequest extends Request implements ServerRequestInterface
{
    public function __construct(
        $method,
        UriInterface $uri,
        HeadersInterface $headers,
        array $cookies,
        array $serverParams,
        StreamInterface $body,
        array $uploadedFiles = []
    )
    {
        parent::__construct($method,
            $uri,
            $headers,
            $cookies,
            $serverParams,
            $body,
            $uploadedFiles
        );
    }


}