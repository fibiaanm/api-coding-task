<?php

namespace App\UI\Http\RequestValidators;

use App\UI\Http\Responses\ResponseBuilder;
use Respect\Validation\Validator;
use Slim\Psr7\Request;

class PaginationValidator
{

    public function __invoke(Request $request, $handler)
    {
        $queryParams = $request->getQueryParams();
        $page = $queryParams['page'] ?? 1;
        $limit = $queryParams['limit'] ?? 10;

        $toValidate = [
            'page' => $page,
            'limit' => $limit,
        ];

        $rules = [
            'page' => Validator::intVal()->positive(),
            'limit' => Validator::intVal()->oneOf(
                Validator::equals(10),
                Validator::equals(20),
                Validator::equals(50)
            ),
        ];

        foreach ($rules as $key => $rule) {
            try {
                $rule->assert($toValidate[$key] ?? null);
            } catch (\Exception $e) {
                return ResponseBuilder::validationError("Field $key is invalid");
            }
        }

        return $handler->handle($request);
    }

}