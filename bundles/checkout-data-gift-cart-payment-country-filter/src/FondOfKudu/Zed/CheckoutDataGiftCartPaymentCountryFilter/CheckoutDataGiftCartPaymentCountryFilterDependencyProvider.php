<?php

namespace FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CheckoutDataGiftCartPaymentCountryFilterDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        return parent::provideBusinessLayerDependencies($container);
    }
}
