<?php

namespace FondOfKudu\Client\CatalogSortPrice;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class CatalogSortPriceDependencyProvider extends AbstractDependencyProvider
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
