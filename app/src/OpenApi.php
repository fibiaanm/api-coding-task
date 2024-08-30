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
    schema: 'CharacterPayload',
    description: 'Standard character',
    properties: [
        new OA\Property(property: 'name', description: 'Updated name of the character', type: 'string', example: 'Updated name'),
        new OA\Property(property: 'faction_id', description: 'Updated faction ID of the character', type: 'integer', example: 1),
        new OA\Property(property: 'kingdom', description: 'Updated kingdom of the character', type: 'string', example: 'Updated kingdom'),
        new OA\Property(property: 'birth_date', description: 'Updated birth date of the character', type: 'string', example: '2021-01-01'),
        new OA\Property(property: 'equipment_id', description: 'Updated equipment ID of the character', type: 'integer', example: 1),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'EquipmentPayload',
    description: 'Standard equipment',
    properties: [
        new OA\Property(property: 'name', description: 'Updated name of the equipment', type: 'string', example: 'Updated name'),
        new OA\Property(property: 'faction_id', description: 'Updated faction ID of the equipment', type: 'integer', example: 1),
        new OA\Property(property: 'kingdom', description: 'Updated kingdom of the equipment', type: 'string', example: 'Updated kingdom'),
        new OA\Property(property: 'birth_date', description: 'Updated birth date of the equipment', type: 'string', example: '2021-01-01'),
        new OA\Property(property: 'equipment_id', description: 'Updated equipment ID of the equipment', type: 'integer', example: 1),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'Character',
    description: 'Standard character',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'El nombre del personaje'),
        new OA\Property(property: 'faction_id', type: 'integer', example: 1),
        new OA\Property(property: 'kingdom', type: 'string', example: 'El reino del personaje'),
        new OA\Property(property: 'birth_date', type: 'string', example: '2021-01-01'),
        new OA\Property(property: 'equipment_id', type: 'integer', example: 1),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'Equipment',
    description: 'Standard equipment',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'El nombre del personaje'),
        new OA\Property(property: 'type', type: 'string', example: 'El tipo del equipo'),
        new OA\Property(property: 'made_by', type: 'string', example: 'El fabricante del equipo'),
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