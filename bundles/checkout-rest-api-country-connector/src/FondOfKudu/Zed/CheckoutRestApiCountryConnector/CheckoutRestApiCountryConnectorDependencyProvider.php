<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector;

use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeBridge;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToProductCountryRestrictionCheckoutConnectorFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CheckoutRestApiCountryConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_COUNTRY = 'FACADE_COUNTRY';

    /**
     * @var string
     */
    public const FACADE_PRODUCT_COUNTRY_RESTRICTION_CHECKOUT_CONNECTOR = 'FACADE_PRODUCT_COUNTRY_RESTRICTION_CHECKOUT_CONNECTOR';

    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addCountryFacade($container);
        $container = $this->addProductCountryRestrictionCheckoutConnectorFacade($container);

        return $container;
    }

    protected function addCountryFacade(Container $container): Container
    {
        $container->set(static::FACADE_COUNTRY, function (Container $container) {
            return new CheckoutRestApiCountryConnectorToCountryFacadeBridge($container->getLocator()->country()->facade());
        });

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
            return new CheckoutRestApiCountryConnectorToProductCountryRestrictionCheckoutConnectorFacadeBridge(
                $container->getLocator()->productCountryRestrictionCheckoutConnector()->facade(),
            );
        });

        return $container;
    }
}
