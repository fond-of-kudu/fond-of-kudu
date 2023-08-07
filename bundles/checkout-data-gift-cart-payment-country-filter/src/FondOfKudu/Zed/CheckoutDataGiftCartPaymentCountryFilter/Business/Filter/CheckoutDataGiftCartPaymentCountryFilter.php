<?php

namespace FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business\Filter;

use ArrayObject;
use FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\CheckoutDataGiftCartPaymentCountryFilterConfig;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class CheckoutDataGiftCartPaymentCountryFilter implements CheckoutDataGiftCartPaymentCountryFilterInterface
{
    /**
     * @var \FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\CheckoutDataGiftCartPaymentCountryFilterConfig
     */
    protected $config;

    /**
     * @param \FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\CheckoutDataGiftCartPaymentCountryFilterConfig $config
     */
    public function __construct(CheckoutDataGiftCartPaymentCountryFilterConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCheckoutDataTransfer $restCheckoutDataTransfer
     * @param \Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCheckoutDataTransfer
     */
    public function filter(
        RestCheckoutDataTransfer $restCheckoutDataTransfer,
        RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
    ): RestCheckoutDataTransfer {
        $availableCountries = new ArrayObject();

        if (!$restCheckoutDataTransfer->getQuote()) {
            return $restCheckoutDataTransfer;
        }

        $blacklistedCountryIso2Codes = $this->config->getBlacklistedCountries();

        if (count($blacklistedCountryIso2Codes) === 0) {
            return $restCheckoutDataTransfer;
        }

        foreach ($restCheckoutDataTransfer->getCountries() as $countryTransfer) {
            if (in_array($countryTransfer->getIso2Code(), $blacklistedCountryIso2Codes)) {
                continue;
            }

            $availableCountries->append($countryTransfer);
        }

        return $restCheckoutDataTransfer->setCountries($availableCountries);
    }
}
