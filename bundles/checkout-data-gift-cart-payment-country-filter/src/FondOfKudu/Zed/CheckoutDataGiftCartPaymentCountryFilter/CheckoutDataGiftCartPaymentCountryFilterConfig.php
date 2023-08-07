<?php

namespace FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter;

use FondOfKudu\Shared\CheckoutDataGiftCartPaymentCountryFilter\CheckoutDataGiftCartPaymentCountryFilterConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class CheckoutDataGiftCartPaymentCountryFilterConfig extends AbstractBundleConfig
{
    /**
     * @return array<string>
     */
    public function getBlacklistedCountries(): array
    {
        return $this->get(
            CheckoutDataGiftCartPaymentCountryFilterConstants::BLACKLISTED_COUNTRIES,
            CheckoutDataGiftCartPaymentCountryFilterConstants::BLACKLISTED_COUNTRIES_VALUE,
        );
    }
}
