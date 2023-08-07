<?php

namespace FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\Filter;

use ArrayObject;
use FondOfKudu\Zed\CheckoutDataProductCountryFilter\Dependency\Facade\CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeInterface;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class CheckoutDataProductCountryFilter implements CheckoutDataProductCountryFilterInterface
{
    /**
     * @var \FondOfKudu\Zed\CheckoutDataProductCountryFilter\Dependency\Facade\CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeInterface
     */
    protected $productCountryRestrictionCheckoutConnectorFacade;

    /**
     * @param \FondOfKudu\Zed\CheckoutDataProductCountryFilter\Dependency\Facade\CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeInterface $productCountryRestrictionCheckoutConnectorFacade
     */
    public function __construct(
        CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeInterface $productCountryRestrictionCheckoutConnectorFacade
    ) {
        $this->productCountryRestrictionCheckoutConnectorFacade = $productCountryRestrictionCheckoutConnectorFacade;
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
        if (!$restCheckoutDataTransfer->getQuote()) {
            return $restCheckoutDataTransfer;
        }

        $availableCountries = new ArrayObject();
        $blacklistedCountryIso2Codes = [];
        $blacklistedCountryCollectionTransfer = $this->productCountryRestrictionCheckoutConnectorFacade
            ->getBlacklistedCountryCollectionByQuote($restCheckoutDataTransfer->getQuote());

        foreach ($blacklistedCountryCollectionTransfer->getBlacklistedCountries() as $blacklistedCountryTransfer) {
            $blacklistedCountryIso2Codes[] = $blacklistedCountryTransfer->getIso2code();
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
