<?php

namespace App\Application\Services;

use App\Application\DataObjects\PaginationObject;
use App\Loaders\SecretsManager;

class CacheDecoratorService
{

    public function __construct(
        private \Redis $redis,
        private SecretsManager $secrets,
        private $service
    )
    {
    }

    /**
     * @throws \RedisException
     */
    public function __call(string $method, array $args)
    {
        if ($method !== 'all' && $method !== 'find') {
            return call_user_func_array([$this->service, $method], $args);
        }

        $cacheKey = $this->generateCacheKey($method, $args);
        $cacheItem = $this->redis->get($cacheKey);

        if ($cacheItem) {
            $dataSerialized = json_decode($cacheItem, true);
            return $this->service->convertFromCache($dataSerialized);
        }

        $result = call_user_func_array([$this->service, $method], $args);
        $dataEncoded = json_encode($result->toArray(), JSON_UNESCAPED_UNICODE);
        $this->redis->set(
            $cacheKey,
            $dataEncoded,
            ['EX' => $this->secrets->secrets['redis']['expire']]
        );

        return $result;
    }

    private function generateCacheKey($method, $args): string
    {
        $key = '';
        if (is_object($this->service) && property_exists($this->service, 'table')) {
            $key .= $this->service->table . ':';
        }
        $key .= $method;

        if (count($args) > 0) {
            $key .= ':';
        }
        foreach ($args as $localKey => $arg) {
            if ($arg instanceof PaginationObject) {
                $key .= $arg->page . ',' . $arg->limit;
            } else {
                $key .= $arg;
            }
        }

        return $key;
    }

}