<?php

namespace FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business;

use FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business\Filter\CheckoutDataGiftCartPaymentCountryFilter;
use FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business\Filter\CheckoutDataGiftCartPaymentCountryFilterInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\CheckoutDataGiftCartPaymentCountryFilterConfig getConfig()
 */
class CheckoutDataGiftCartPaymentCountryFilterBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business\Filter\CheckoutDataGiftCartPaymentCountryFilterInterface
     */
    public function createCheckoutDataGiftCartPaymentCountryFilter(): CheckoutDataGiftCartPaymentCountryFilterInterface
    {
        return new CheckoutDataGiftCartPaymentCountryFilter($this->getConfig());
    }
}
