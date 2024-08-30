<?php

namespace App;

use GuzzleHttp\Client;

class TokenHelper
{

    static string $token = "";

    public static function getToken(): string
    {
        if (self::$token) {
            return self::$token;
        }
        $client = new Client([
            'base_uri' => 'http://localhost:8080',
            'http_errors' => false,
        ]);
        $response = $client->post('/auth/login', [
            'json' => [
                'name' => 'admin',
                'password' => '1f3d38abc5b698ad3c95341edefeb469'
            ]
        ]);
        $responseData = json_decode($response->getBody(), true);
        $userData = $responseData['data']['user'];
        self::$token = $userData['token'];
        return self::$token;
    }

}