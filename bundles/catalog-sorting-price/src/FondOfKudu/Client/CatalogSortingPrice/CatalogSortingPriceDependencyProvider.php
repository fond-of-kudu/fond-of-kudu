<?php

namespace FondOfKudu\Client\CatalogSortingPrice;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class CatalogSortingPriceDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        return parent::provideServiceLayerDependencies($container);
    }
}
