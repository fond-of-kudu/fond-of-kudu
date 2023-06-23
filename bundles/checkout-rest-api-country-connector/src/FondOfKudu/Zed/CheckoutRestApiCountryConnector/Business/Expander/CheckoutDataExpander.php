<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander;

use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeInterface;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToProductCountryRestrictionCheckoutConnectorFacadeInterface;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class CheckoutDataExpander implements CheckoutDataExpanderInterface
{
    private $productCountryRestrictionCheckoutConnectorFacade;

    private CheckoutRestApiCountryConnectorToCountryFacadeInterface $countryFacade;

    /**
     * @param \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToProductCountryRestrictionCheckoutConnectorFacadeInterface $productCountryRestrictionCheckoutConnectorFacade
     * @param \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeInterface $countryFacade
     */
    public function __construct(
        CheckoutRestApiCountryConnectorToProductCountryRestrictionCheckoutConnectorFacadeInterface $productCountryRestrictionCheckoutConnectorFacade,
        CheckoutRestApiCountryConnectorToCountryFacadeInterface $countryFacade
    ) {
        $this->productCountryRestrictionCheckoutConnectorFacade = $productCountryRestrictionCheckoutConnectorFacade;
        $this->countryFacade = $countryFacade;
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
        $blacklistedCountryCollectionTransfer = $this->productCountryRestrictionCheckoutConnectorFacade
            ->getBlacklistedCountryCollectionByQuote($restCheckoutDataTransfer->getQuote());

        foreach ($blacklistedCountryCollectionTransfer->getBlacklistedCountries() as $blacklistedCountryTransfer) {
            $foo = $blacklistedCountryTransfer;
        }

        if (!$restCheckoutDataTransfer->getQuote()) {
            return $restCheckoutDataTransfer;
        }

        $countriesCollectionTransfer = $this->countryFacade->getAvailableCountries();

        foreach ($countriesCollectionTransfer->getCountries() as $country) {
            $restCheckoutDataTransfer->addCountry($country);
        }

        return $restCheckoutDataTransfer;
    }
}
