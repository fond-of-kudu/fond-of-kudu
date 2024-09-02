<?php

namespace FondOfKudu\Client\SecurityBlockerReset\Dependency\Client;

use Generated\Shared\Transfer\RedisConfigurationTransfer;
use Spryker\Client\Redis\RedisClientInterface;

class SecurityBlockerResetToRedisClientBridge implements SecurityBlockerResetToRedisClientInterface
{
    /**
     * @var \Spryker\Client\Redis\RedisClientInterface
     */
    protected RedisClientInterface $redisClient;

    /**
     * @param \Spryker\Client\Redis\RedisClientInterface $redisClient
     */
    public function __construct(RedisClientInterface $redisClient)
    {
        $this->redisClient = $redisClient;
    }

    /**
     * @param string $connectionKey
     * @param array<string> $keys
     *
     * @return int
     */
    public function del(string $connectionKey, array $keys): int
    {
        return $this->redisClient->del($connectionKey, $keys);
    }

    /**
     * @param string $connectionKey
     * @param \Generated\Shared\Transfer\RedisConfigurationTransfer $configurationTransfer
     *
     * @return void
     */
    public function setupConnection(string $connectionKey, RedisConfigurationTransfer $configurationTransfer): void
    {
        $this->redisClient->setupConnection($connectionKey, $configurationTransfer);
    }
}
