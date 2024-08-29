<?php

namespace App;
use OpenApi\Attributes as OA;
#[OA\Schema(
    schema: 'ErrorResponse',
    description: 'Standard error response',
    properties: [
        new OA\Property(property: 'status', type: 'integer', example: 404),
        new OA\Property(property: 'message', type: 'string', example: 'Route not found'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'Factions',
    description: 'Standard faction',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'El nombre de la facción'),
        new OA\Property(property: 'description', type: 'string', example: 'Es una facción en español, entonces necesita ñ y tíldes')
    ],
    type: 'object'
)]

#[OA\Schema(
    schema: 'ServerErrorResponse',
    description: 'Server error response',
    properties: [
        new OA\Property(property: 'status', type: 'integer', example: 500),
        new OA\Property(property: 'message', type: 'string', example: 'Internal Server Error'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ForbiddenResponse',
    description: 'Server forbidden response',
    properties: [
        new OA\Property(property: 'status', type: 'string', example: 'error'),
        new OA\Property(property: 'message', type: 'string', example: 'Forbidden'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ResourceNotFoundResponse',
    description: 'Resource not found response',
    properties: [
        new OA\Property(property: 'status', type: 'string', example: 'error'),
        new OA\Property(property: 'message', type: 'string', example: 'Resource not found'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ValidationError',
    description: 'Validation error response',
    properties: [
        new OA\Property(property: 'status', type: 'string', example: 'error'),
        new OA\Property(property: 'message', type: 'string', example: 'Field "name" is required'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'UnauthorizedResponse',
    properties: [
        new OA\Property(property: 'status', type: 'string', example: 'error'),
        new OA\Property(property: 'message', type: 'string', example: 'Unauthorized')
    ],
    type: 'object'
)]
#[OA\Info(
    version: '1.0.0',
    description: 'Description of your API',
    title: 'Your API Title'
)]
class OpenApi
{

}