<?php

namespace FondOfKudu\Client\ProductImageStorageConnector;

use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientBridge;
use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientInterface;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class ProductImageStorageConnectorDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_PRODUCT_IMAGE_STORAGE = 'CLIENT_PRODUCT_IMAGE_STORAGE';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = $this->addProductImageStorageClient($container);

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
}
