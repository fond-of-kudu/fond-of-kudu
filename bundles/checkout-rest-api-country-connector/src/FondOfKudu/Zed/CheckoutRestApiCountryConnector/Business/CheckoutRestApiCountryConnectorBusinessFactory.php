<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business;

use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander\CheckoutDataExpander;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander\CheckoutDataExpanderInterface;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\CheckoutRestApiCountryConnectorDependencyProvider;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeInterface;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToProductCountryRestrictionCheckoutConnectorFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class CheckoutRestApiCountryConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander\CheckoutDataExpanderInterface
     */
    public function createCheckoutDataExpander(): CheckoutDataExpanderInterface
    {
        return new CheckoutDataExpander(
            $this->getProductCountryRestrictionCheckoutConnectorFacade(),
            $this->getCountryFacade(),
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
     * @return \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToProductCountryRestrictionCheckoutConnectorFacadeInterface
     */
    protected function getProductCountryRestrictionCheckoutConnectorFacade(): CheckoutRestApiCountryConnectorToProductCountryRestrictionCheckoutConnectorFacadeInterface
    {
        return $this->getProvidedDependency(CheckoutRestApiCountryConnectorDependencyProvider::FACADE_PRODUCT_COUNTRY_RESTRICTION_CHECKOUT_CONNECTOR);
    }
}
