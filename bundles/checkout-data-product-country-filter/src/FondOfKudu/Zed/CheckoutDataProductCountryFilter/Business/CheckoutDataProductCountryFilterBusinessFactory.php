<?php

namespace FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business;

use FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\Filter\CheckoutDataProductCountryFilter;
use FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\Filter\CheckoutDataProductCountryFilterInterface;
use FondOfKudu\Zed\CheckoutDataProductCountryFilter\CheckoutDataProductCountryFilterDependencyProvider;
use FondOfKudu\Zed\CheckoutDataProductCountryFilter\Dependency\Facade\CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class CheckoutDataProductCountryFilterBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\Filter\CheckoutDataProductCountryFilterInterface
     */
    public function createCheckoutDataProductCountryFilter(): CheckoutDataProductCountryFilterInterface
    {
        return new CheckoutDataProductCountryFilter($this->getProductCountryRestrictionCheckoutConnectorFacade());
    }

    /**
     * @return \FondOfKudu\Zed\CheckoutDataProductCountryFilter\Dependency\Facade\CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeInterface
     */
    protected function getProductCountryRestrictionCheckoutConnectorFacade(): CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeInterface
    {
        return $this->getProvidedDependency(CheckoutDataProductCountryFilterDependencyProvider::FACADE_PRODUCT_COUNTRY_RESTRICTION_CHECKOUT_CONNECTOR);
    }
}
