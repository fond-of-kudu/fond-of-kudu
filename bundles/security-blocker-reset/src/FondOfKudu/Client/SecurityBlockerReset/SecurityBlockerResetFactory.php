<?php

namespace FondOfKudu\Client\SecurityBlockerReset;

use FondOfKudu\Client\SecurityBlockerReset\Dependency\Client\SecurityBlockerResetToRedisClientInterface;
use FondOfKudu\Client\SecurityBlockerReset\Redis\SecurityBlockerResetWrapper;
use FondOfKudu\Client\SecurityBlockerReset\Redis\SecurityBlockerResetWrapperInterface;
use FondOfKudu\Client\SecurityBlockerReset\Storage\Resetter\SecurityBlockerResetStorageResetter;
use FondOfKudu\Client\SecurityBlockerReset\Storage\Resetter\SecurityBlockerResetStorageResetterInterface;
use Spryker\Client\Kernel\AbstractFactory;

/**
 * @method \FondOfKudu\Client\SecurityBlockerReset\SecurityBlockerResetConfig getConfig()
 */
class SecurityBlockerResetFactory extends AbstractFactory
{
    /**
     * @return \FondOfKudu\Client\SecurityBlockerReset\Storage\Resetter\SecurityBlockerResetStorageResetterInterface
     */
    public function createSecurityBlockerResetStorageResetter(): SecurityBlockerResetStorageResetterInterface
    {
        return new SecurityBlockerResetStorageResetter($this->createSecurityBlockerResetWrapper());
    }

    /**
     * @return \FondOfKudu\Client\SecurityBlockerReset\Redis\SecurityBlockerResetWrapperInterface
     */
    public function createSecurityBlockerResetWrapper(): SecurityBlockerResetWrapperInterface
    {
        return new SecurityBlockerResetWrapper(
            $this->getRedisClient(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfKudu\Client\SecurityBlockerReset\Dependency\Client\SecurityBlockerResetToRedisClientInterface
     */
    public function getRedisClient(): SecurityBlockerResetToRedisClientInterface
    {
        return $this->getProvidedDependency(SecurityBlockerResetDependencyProvider::CLIENT_REDIS);
    }
}
