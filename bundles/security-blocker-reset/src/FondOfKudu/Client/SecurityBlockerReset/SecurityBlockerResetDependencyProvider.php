<?php

namespace FondOfKudu\Client\SecurityBlockerReset;

use FondOfKudu\Client\SecurityBlockerReset\Dependency\Client\SecurityBlockerResetToRedisClientBridge;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class SecurityBlockerResetDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_REDIS = 'CLIENT_REDIS';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = parent::provideServiceLayerDependencies($container);
        $container = $this->addRedisClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addRedisClient(Container $container): Container
    {
        $container->set(static::CLIENT_REDIS, function (Container $container) {
            return new SecurityBlockerResetToRedisClientBridge(
                $container->getLocator()->redis()->client(),
            );
        });

        return $container;
    }
}
