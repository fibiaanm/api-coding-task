<?php

namespace Integration;

use App\TokenHelper;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class CharacterApiTest extends TestCase
{

    protected $client;
    private string $token = "";
    static int $characterId = 0;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8080',
            'http_errors' => false,
        ]);
        $this->token = TokenHelper::getToken();
    }

    public function testCreateCharacterApi(): void
    {
        $response = $this->client->post('/api/characters', [
            'json' => [
                'name' => 'Character Test',
                'birth_date' => '2021-01-01',
                'faction_id' => 1,
                'kingdom' => 'Kingdom Test',
                'equipment_id' => 1,
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());
        $responseResult = json_decode($response->getBody(), true);
        $this->assertEquals('Character Test', $responseResult['data']['name']);
        $this->assertEquals('2021-01-01', $responseResult['data']['birth_date']);
        $this->assertEquals(1, $responseResult['data']['factionId']);
        $this->assertEquals('Kingdom Test', $responseResult['data']['kingdom']);
        $this->assertEquals(1, $responseResult['data']['equipmentId']);
        self::$characterId = $responseResult['data']['id'];
    }

    public function testListCharactersApi(): void
    {
        $response = $this->client->get('/api/characters');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDetailCharacterApi(): void
    {
        $response = $this->client->get('/api/characters/' . self::$characterId);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateCharacterApi(): void
    {
        $response = $this->client->put('/api/characters/' . self::$characterId, [
            'json' => [
                'name' => 'Character Test Updated',
                'birth_date' => '2021-01-02',
                'faction_id' => 2,
                'kingdom' => 'Kingdom Test Updated',
                'equipment_id' => 2,
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $responseResult = json_decode($response->getBody(), true);
        $this->assertEquals('Character Test Updated', $responseResult['data']['name']);
        $this->assertEquals('2021-01-02', $responseResult['data']['birth_date']);
        $this->assertEquals(2, $responseResult['data']['factionId']);
        $this->assertEquals('Kingdom Test Updated', $responseResult['data']['kingdom']);
        $this->assertEquals(2, $responseResult['data']['equipmentId']);
    }

    public function testDeleteCharacterApi(): void
    {
        $response = $this->client->delete('/api/characters/' . self::$characterId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCacheResponseOnDetailDeletedApi()
    {
        $response = $this->client->get('/api/characters/' . self::$characterId);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCantCreateCharacterWithoutToken(): void
    {
        $response = $this->client->post('/api/characters', [
            'json' => [
                'name' => 'Character Test',
                'birth_date' => '2021-01-01',
                'faction_id' => 1,
                'kingdom' => 'Kingdom Test',
                'equipment_id' => 1,
            ],
        ]);
        $this->assertEquals(401, $response->getStatusCode());
    }

}