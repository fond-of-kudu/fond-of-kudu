<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business;

use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander\CountryGiftCardFilterCheckoutDataExpander;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander\CountryProductFilterCountryCheckoutDataExpander;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander\CountryCheckoutDataExpanderInterface;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\CheckoutRestApiCountryConnectorDependencyProvider;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeInterface;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToProductCountryRestrictionCheckoutConnectorFacadeInterface;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToStoreFacadeInterface;
use FondOfOryx\Zed\GiftCardRestriction\GiftCardRestrictionConfig;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class CheckoutRestApiCountryConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander\CountryCheckoutDataExpanderInterface
     */
    public function createCountryProductFilterCheckoutDataExpander(): CountryCheckoutDataExpanderInterface
    {
        return new CountryProductFilterCountryCheckoutDataExpander(
            $this->getProductCountryRestrictionCheckoutConnectorFacade(),
            $this->getStoreFacade(),
            $this->getCountryFacade(),
        );
    }

    /**
     * @return \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander\CountryCheckoutDataExpanderInterface
     */
    public function createCountryGiftCardFilterCheckoutDataExpander(): CountryCheckoutDataExpanderInterface
    {
        return new CountryGiftCardFilterCheckoutDataExpander($this->createGiftCardRestrictionConfig());
    }

    /**
     * @return GiftCardRestrictionConfig
     */
    protected function createGiftCardRestrictionConfig(): GiftCardRestrictionConfig
    {
        return new GiftCardRestrictionConfig();
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

    /**
     * @return \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToStoreFacadeInterface
     */
    protected function getStoreFacade(): CheckoutRestApiCountryConnectorToStoreFacadeInterface
    {
        return $this->getProvidedDependency(CheckoutRestApiCountryConnectorDependencyProvider::FACADE_STORE);
    }
}
