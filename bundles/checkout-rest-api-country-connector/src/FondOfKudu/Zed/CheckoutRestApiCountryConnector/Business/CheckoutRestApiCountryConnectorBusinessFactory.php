<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business;

use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander\CheckoutDataExpander;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander\CheckoutDataExpanderInterface;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\CheckoutRestApiCountryConnectorDependencyProvider;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeInterface;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToStoreFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class CheckoutRestApiCountryConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander\CheckoutDataExpanderInterface
     */
    public function createCheckoutDataExpander(): CheckoutDataExpanderInterface
    {
        return new CheckoutDataExpander(
            $this->getStoreFacade(),
            $this->getCountryFacade(),
            $this->getCheckoutRestApiCountryFilterPlugins(),
        );
    }

    /**
     * @return \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeInterface
     */
    public function getCountryFacade(): CheckoutRestApiCountryConnectorToCountryFacadeInterface
    {
        return $this->getProvidedDependency(CheckoutRestApiCountryConnectorDependencyProvider::FACADE_COUNTRY);
    }

    /**
     * @return \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToStoreFacadeInterface
     */
    protected function getStoreFacade(): CheckoutRestApiCountryConnectorToStoreFacadeInterface
    {
        return $this->getProvidedDependency(CheckoutRestApiCountryConnectorDependencyProvider::FACADE_STORE);
    }

    /**
     * @return array<\FondOfKudu\Zed\CheckoutRestApiCountryExtension\Dependency\Plugin\CheckoutRestApiCountryFilterPluginInterface>
     */
    protected function getCheckoutRestApiCountryFilterPlugins(): array
    {
        return $this->getProvidedDependency(
            CheckoutRestApiCountryConnectorDependencyProvider::CHECKOUT_REST_API_COUNTRY_FILTER_PLUGINS,
        );
    }
}
