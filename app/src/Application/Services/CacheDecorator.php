<?php

namespace App\Application\Services;

use App\Loaders\SecretsManager;

class CacheDecorator
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
        // Generate a unique cache key based on method name and arguments
        return $method . serialize($args);
    }

}