<?php

namespace App\UI\Http\Controllers\RequestValidators;

use App\UI\Http\Responses\ResponseBuilder;
use Respect\Validation\Validator;
use Slim\Psr7\Request;

class LoginUserValidation
{

    public function __invoke(Request $request, $handler)
    {
        $body = $request->getBody();
        $data = json_decode($body, true);

        $rules = [
            'name' => Validator::stringType()->notEmpty()->length(3),
            'password' => Validator::stringType()->notEmpty()->length(3),
        ];

        foreach ($rules as $key => $rule) {
            try {
                $rule->assert($data[$key] ?? null);
            } catch (\Exception $e) {
                return ResponseBuilder::validationError("Field $key is invalid");
            }
        }

        return $handler->handle($request);

    }

}