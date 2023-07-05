<?php

namespace FondOfKudu\Client\ProductImageStorageConnector;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class ProductImageStorageConnectorDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        return $container;
    }
}
