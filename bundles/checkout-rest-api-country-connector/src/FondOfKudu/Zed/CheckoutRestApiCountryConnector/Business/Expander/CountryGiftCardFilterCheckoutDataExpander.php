<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander;

use FondOfOryx\Zed\GiftCardRestriction\GiftCardRestrictionConfig;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class CountryGiftCardFilterCheckoutDataExpander implements CountryCheckoutDataExpanderInterface
{
    /**
     * @var \FondOfOryx\Zed\GiftCardRestriction\GiftCardRestrictionConfig $cardRestrictionConfig
     */
    private $cardRestrictionConfig;

    /**
     * @param \FondOfOryx\Zed\GiftCardRestriction\GiftCardRestrictionConfig $cardRestrictionConfig
     */
    public function __construct(GiftCardRestrictionConfig $cardRestrictionConfig)
    {
        $this->cardRestrictionConfig = $cardRestrictionConfig;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCheckoutDataTransfer $restCheckoutDataTransfer
     * @param \Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCheckoutDataTransfer
     */
    public function expandCheckoutDataWithCountries(
        RestCheckoutDataTransfer $restCheckoutDataTransfer,
        RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
    ): RestCheckoutDataTransfer {
        if (!$restCheckoutDataTransfer->getQuote()) {
            return $restCheckoutDataTransfer;
        }

        if ($restCheckoutDataTransfer->getQuote()->getGiftCards()->count() === 0) {
            return $restCheckoutDataTransfer;
        }

        $quoteTransfer = $restCheckoutDataTransfer->getQuote();

        return $restCheckoutDataTransfer;
    }
}
