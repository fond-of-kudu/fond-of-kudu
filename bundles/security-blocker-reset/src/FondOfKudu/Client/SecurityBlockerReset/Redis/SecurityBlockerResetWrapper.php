<?php

namespace FondOfKudu\Client\SecurityBlockerReset\Redis;

use FondOfKudu\Client\SecurityBlockerReset\Dependency\Client\SecurityBlockerResetToRedisClientInterface;
use FondOfKudu\Client\SecurityBlockerReset\SecurityBlockerResetConfig;

class SecurityBlockerResetWrapper implements SecurityBlockerResetWrapperInterface
{
    /**
     * @var string
     */
    protected const KV_PREFIX = 'kv:';

    /**
     * @var \FondOfKudu\Client\SecurityBlockerReset\Dependency\Client\SecurityBlockerResetToRedisClientInterface
     */
    protected SecurityBlockerResetToRedisClientInterface $redisClient;

    /**
     * @var \FondOfKudu\Client\SecurityBlockerReset\SecurityBlockerResetConfig
     */
    protected SecurityBlockerResetConfig $securityBlockerResetConfig;

    /**
     * @param \FondOfKudu\Client\SecurityBlockerReset\Dependency\Client\SecurityBlockerResetToRedisClientInterface $redisClient
     * @param \FondOfKudu\Client\SecurityBlockerReset\SecurityBlockerResetConfig $securityBlockerResetConfig
     */
    public function __construct(SecurityBlockerResetToRedisClientInterface $redisClient, SecurityBlockerResetConfig $securityBlockerResetConfig)
    {
        $this->redisClient = $redisClient;
        $this->securityBlockerResetConfig = $securityBlockerResetConfig;

        $this->setupConnection();
    }

    /**
     * @param array<string> $keys
     *
     * @return int
     */
    public function del(array $keys): int
    {
        return $this->redisClient->del(
            $this->securityBlockerResetConfig->getRedisConnectionKey(),
            array_map(fn (string $key) => $this->getStorageKey($key), $keys),
        );
    }

    /**
     * @return void
     */
    protected function setupConnection(): void
    {
        $this->redisClient->setupConnection(
            $this->securityBlockerResetConfig->getRedisConnectionKey(),
            $this->securityBlockerResetConfig->getRedisConnectionConfiguration(),
        );
    }

    /**
     * @param string $key
     *
     * @return string
     */
    protected function getStorageKey(string $key = '*'): string
    {
        return static::KV_PREFIX . $key;
    }
}
