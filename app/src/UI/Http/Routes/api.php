<?php

/**
 * Main application routes and configuration.
 *
 * @package    App
 * @subpackage UI\Http
 */

use App\UI\Http\Controllers\Api\HomeController;
use App\UI\Http\Controllers\Factions\CreateFactionController;
use App\UI\Http\Controllers\Factions\DeleteFactionController;
use App\UI\Http\Controllers\Factions\DetailFactionController;
use App\UI\Http\Controllers\Factions\ListFactionsController;
use App\UI\Http\Controllers\Factions\UpdateFactionController;
use App\UI\Http\Controllers\Equipments\ListEquipmentController;
use App\UI\Http\Controllers\Equipments\DetailEquipmentController;
use App\UI\Http\Controllers\Equipments\CreateEquipmentController;
use App\UI\Http\Controllers\Equipments\UpdateEquipmentController;
use App\UI\Http\Controllers\Equipments\DeleteEquipmentController;
use App\UI\Http\Controllers\Characters\ListCharactersController;
use App\UI\Http\Controllers\Characters\DetailCharacterController;
use App\UI\Http\Controllers\Characters\CreateCharacterController;
use App\UI\Http\Controllers\Characters\UpdateCharacterController;
use App\UI\Http\Controllers\Characters\DeleteCharacterController;
use App\UI\Http\Controllers\Users\LoginController;
use App\UI\Http\Controllers\Api\DocumentationController;
use App\UI\Http\Middlewares\AuthMiddleware;
use App\UI\Http\RequestValidators\CreateFactionValidator;
use App\UI\Http\RequestValidators\CreateCharacterValidator;
use App\UI\Http\RequestValidators\CreateEquipmentValidator;
use App\UI\Http\RequestValidators\LoginUserValidation;
use App\UI\Http\RequestValidators\PaginationValidator;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;
use Slim\Routing\RouteCollectorProxy;

/**
 * @var \Slim\App $app
 */

$app->group(
    '/api',
    function (
        RouteCollectorProxy $apiGroup
    ) {
        $apiGroup->get('', HomeController::class);
        $apiGroup->get('/documentation', DocumentationController::class);

        $apiGroup->group(
            '/characters',
            function (
                RouteCollectorProxy $characters
            ) {
                $characters->get(
                    '',
                    ListCharactersController::class
                )->add(
                    PaginationValidator::class
                );

                $characters->get(
                    '/{id:[0-9]+}',
                    DetailCharacterController::class
                );

                $characters->group(
                    '',
                    function (
                        RouteCollectorProxy $characters
                    ) {
                        $characters->post(
                            '',
                            CreateCharacterController::class
                        )
                        ->add(
                            CreateCharacterValidator::class
                        );

                        $characters->put(
                            '/{id:[0-9]+}',
                            UpdateCharacterController::class
                        )
                        ->add(
                            CreateCharacterValidator::class
                        );

                        $characters->delete(
                            '/{id:[0-9]+}',
                            DeleteCharacterController::class
                        );
                    }
                )
                ->add(
                    authorization(['admin'])
                )
                    ->add(
                        AuthMiddleware::class
                    );
            }
        );

        $apiGroup->group(
            '/factions',
            function (
                RouteCollectorProxy $factions
            ) {
                $factions->get(
                    '',
                    ListFactionsController::class
                )->add(
                    PaginationValidator::class
                );
                $factions->get(
                    '/{id:[0-9]+}',
                    DetailFactionController::class
                );

                $factions->group(
                    '',
                    function (
                        RouteCollectorProxy $factions
                    ) {
                        $factions->post(
                            '',
                            CreateFactionController::class
                        )->add(
                            CreateFactionValidator::class
                        );
                        $factions->put(
                            '/{id:[0-9]+}',
                            UpdateFactionController::class
                        )->add(
                            CreateFactionValidator::class
                        );
                        $factions->delete(
                            '/{id:[0-9]+}',
                            DeleteFactionController::class
                        );
                    }
                )
                ->add(
                    authorization(['admin'])
                )
                ->add(
                    AuthMiddleware::class
                );
            }
        );

        $apiGroup->group(
            '/equipments',
            function (
                RouteCollectorProxy $equipments
            ) {
                $equipments->get(
                    '',
                    ListEquipmentController::class
                )->add(
                    PaginationValidator::class
                );

                $equipments->get(
                    '/{id:[0-9]+}',
                    DetailEquipmentController::class
                );

                $equipments->group(
                    '',
                    function (
                        RouteCollectorProxy $equipments
                    ) {
                        $equipments->post(
                            '',
                            CreateEquipmentController::class
                        )
                        ->add(
                            CreateEquipmentValidator::class
                        );

                        $equipments->put(
                            '/{id:[0-9]+}',
                            UpdateEquipmentController::class
                        )
                        ->add(
                            CreateEquipmentValidator::class
                        );

                        $equipments->delete(
                            '/{id:[0-9]+}',
                            DeleteEquipmentController::class
                        );
                    }
                )
                ->add(
                    authorization(['admin'])
                )
                ->add(
                    AuthMiddleware::class
                );
            }
        );
    }
);

/**
 * TODO: Implement documentation
 * TODO: Implement testing
 */

$app->group(
    '/auth', function (RouteCollectorProxy $group) {
        $group->post(
            '/login',
            LoginController::class
        )->add(
            LoginUserValidation::class
        );
    }
);

$app->get(
    '', function (Request $request, Response $response) {
        phpinfo();
        $response->withHeader('Content-Type', 'text/html');
    }
);

$app->get('/test', ListFactionsController::class);
