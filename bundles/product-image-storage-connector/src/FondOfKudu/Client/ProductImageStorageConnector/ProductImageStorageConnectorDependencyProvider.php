<?php

namespace FondOfKudu\Client\ProductImageStorageConnector;

use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToStorageBridge;
use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToStorageInterface;
use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Service\ProductImageStorageConnectorToSynchronizationServiceBridge;
use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Service\ProductImageStorageConnectorToSynchronizationServiceInterface;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class ProductImageStorageConnectorDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_STORAGE = 'CLIENT_STORAGE';

    /**
     * @var string
     */
    public const SERVICE_SYNCHRONIZATION = 'SERVICE_SYNCHRONIZATION';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = $this->addStorageClient($container);
        $container = $this->addSynchronizationService($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addStorageClient(Container $container): Container
    {
        $container[static::CLIENT_STORAGE] = static fn (
            Container $container
        ): ProductImageStorageConnectorToStorageInterface => new ProductImageStorageConnectorToStorageBridge(
            $container->getLocator()->storage()->client(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function addSynchronizationService(Container $container): Container
    {
        $container[static::SERVICE_SYNCHRONIZATION] = static fn (
            Container $container
        ): ProductImageStorageConnectorToSynchronizationServiceInterface => new ProductImageStorageConnectorToSynchronizationServiceBridge(
            $container->getLocator()->synchronization()->service(),
        );

        return $container;
    }
}
