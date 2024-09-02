<?php

namespace FondOfKudu\Client\SecurityBlockerReset\Dependency\Client;

use Generated\Shared\Transfer\RedisConfigurationTransfer;

interface SecurityBlockerResetToRedisClientInterface
{
    /**
     * @param string $connectionKey
     * @param array<string> $keys
     *
     * @return int
     */
    public function del(string $connectionKey, array $keys): int;

    /**
     * @param string $connectionKey
     * @param \Generated\Shared\Transfer\RedisConfigurationTransfer $configurationTransfer
     *
     * @return void
     */
    public function setupConnection(string $connectionKey, RedisConfigurationTransfer $configurationTransfer): void;
}
