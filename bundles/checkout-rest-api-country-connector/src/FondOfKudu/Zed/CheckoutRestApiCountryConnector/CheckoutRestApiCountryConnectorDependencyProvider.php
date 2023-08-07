<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector;

use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeBridge;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToStoreFacadeBridge;
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
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @var string
     */
    public const CHECKOUT_REST_API_COUNTRY_FILTER_PLUGINS = 'CHECKOUT_REST_API_COUNTRY_FILTER_PLUGINS';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addCountryFacade($container);
        $container = $this->addStoreFacade($container);
        $container = $this->addCheckoutRestApiCountryFilterPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
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
    protected function addStoreFacade(Container $container): Container
    {
        $container->set(static::FACADE_STORE, function (Container $container) {
            return new CheckoutRestApiCountryConnectorToStoreFacadeBridge($container->getLocator()->store()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCheckoutRestApiCountryFilterPlugins(Container $container): Container
    {
        $container->set(static::CHECKOUT_REST_API_COUNTRY_FILTER_PLUGINS, function () {
            return $this->getCheckoutRestApiCountryFilterPlugins();
        });

        return $container;
    }

    /**
     * @return array<\FondOfKudu\Zed\CheckoutRestApiCountryExtension\Dependency\Plugin\CheckoutRestApiCountryFilterPluginInterface>
     */
    protected function getCheckoutRestApiCountryFilterPlugins(): array
    {
        return [];
    }
}
