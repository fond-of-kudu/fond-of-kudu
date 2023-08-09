<?php

namespace FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business\Filter;

use ArrayObject;
use FondOfKudu\Shared\CheckoutDataGiftCartPaymentCountryFilter\CheckoutDataGiftCartPaymentCountryFilterConstants;
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

        if (!$restCheckoutDataTransfer->getQuote() || !$this->hasGiftCardPaymentMethod($restCheckoutDataTransfer)) {
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

    /**
     * @param \Generated\Shared\Transfer\RestCheckoutDataTransfer $restCheckoutDataTransfer
     *
     * @return bool
     */
    protected function hasGiftCardPaymentMethod(RestCheckoutDataTransfer $restCheckoutDataTransfer): bool
    {
        foreach ($restCheckoutDataTransfer->getQuote()->getPayments() as $paymentTransfer) {
            if ($paymentTransfer->getPaymentMethod() === CheckoutDataGiftCartPaymentCountryFilterConstants::PAYMENT_METHOD_GIFT_CARD) {
                return true;
            }
        }

        return false;
    }
}
