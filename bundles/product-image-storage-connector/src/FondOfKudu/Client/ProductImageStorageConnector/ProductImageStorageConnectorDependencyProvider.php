<?php

namespace FondOfKudu\Client\ProductImageStorageConnector;

use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToLocaleClientBridge;
use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToLocaleClientInterface;
use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientBridge;
use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientInterface;
use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToStorageClientBridge;
use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToStorageClientInterface;
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
     * @var string
     */
    public const CLIENT_PRODUCT_IMAGE_STORAGE = 'CLIENT_PRODUCT_IMAGE_STORAGE';

    /**
     * @var string
     */
    public const CLIENT_LOCALE = 'CLIENT_LOCALE';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = $this->addStorageClient($container);
        $container = $this->addSynchronizationService($container);
        $container = $this->addProductImageStorageClient($container);

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
        ): ProductImageStorageConnectorToStorageClientInterface => new ProductImageStorageConnectorToStorageClientBridge(
            $container->getLocator()->storage()->client(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addSynchronizationService(Container $container): Container
    {
        $container[static::SERVICE_SYNCHRONIZATION] = static fn (
            Container $container
        ): ProductImageStorageConnectorToSynchronizationServiceInterface => new ProductImageStorageConnectorToSynchronizationServiceBridge(
            $container->getLocator()->synchronization()->service(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addProductImageStorageClient(Container $container): Container
    {
        $container[static::CLIENT_PRODUCT_IMAGE_STORAGE] = static fn (
            Container $container
        ): ProductImageStorageConnectorToProductImageStorageClientInterface => new ProductImageStorageConnectorToProductImageStorageClientBridge(
            $container->getLocator()->productImageStorage()->client(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addLocaleClient(Container $container): Container
    {
        $container[static::CLIENT_LOCALE] = static fn (
            Container $container
        ): ProductImageStorageConnectorToLocaleClientInterface => new ProductImageStorageConnectorToLocaleClientBridge(
            $container->getLocator()->locale()->client(),
        );

        return $container;
    }
}
