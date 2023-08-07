<?php

namespace FondOfKudu\Zed\CheckoutDataProductCountryFilter;

use FondOfKudu\Zed\CheckoutDataProductCountryFilter\Dependency\Facade\CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CheckoutDataProductCountryFilterDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_PRODUCT_COUNTRY_RESTRICTION_CHECKOUT_CONNECTOR = 'FACADE_PRODUCT_COUNTRY_RESTRICTION_CHECKOUT_CONNECTOR';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addProductCountryRestrictionCheckoutConnectorFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductCountryRestrictionCheckoutConnectorFacade(Container $container): Container
    {
        $container->set(static::FACADE_PRODUCT_COUNTRY_RESTRICTION_CHECKOUT_CONNECTOR, function (Container $container) {
            return new CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeBridge(
                $container->getLocator()->productCountryRestrictionCheckoutConnector()->facade(),
            );
        });

        return $container;
    }
}
