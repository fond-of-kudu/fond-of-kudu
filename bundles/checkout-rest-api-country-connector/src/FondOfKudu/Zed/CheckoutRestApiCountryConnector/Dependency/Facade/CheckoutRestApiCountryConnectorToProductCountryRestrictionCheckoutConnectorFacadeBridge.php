<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade;

use FondOfOryx\Zed\ProductCountryRestrictionCheckoutConnector\Business\ProductCountryRestrictionCheckoutConnectorFacadeInterface;
use Generated\Shared\Transfer\BlacklistedCountryCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class CheckoutRestApiCountryConnectorToProductCountryRestrictionCheckoutConnectorFacadeBridge implements CheckoutRestApiCountryConnectorToProductCountryRestrictionCheckoutConnectorFacadeInterface
{
    private ProductCountryRestrictionCheckoutConnectorFacadeInterface $productCountryRestrictionCheckoutConnectorFacade;

    /**
     * @param \FondOfOryx\Zed\ProductCountryRestrictionCheckoutConnector\Business\ProductCountryRestrictionCheckoutConnectorFacadeInterface $productCountryRestrictionCheckoutConnectorFacade
     */
    public function __construct(
        ProductCountryRestrictionCheckoutConnectorFacadeInterface $productCountryRestrictionCheckoutConnectorFacade
    ) {
        $this->productCountryRestrictionCheckoutConnectorFacade = $productCountryRestrictionCheckoutConnectorFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\BlacklistedCountryCollectionTransfer
     */
    public function getBlacklistedCountryCollectionByQuote(
        QuoteTransfer $quoteTransfer
    ): BlacklistedCountryCollectionTransfer {
        return $this->productCountryRestrictionCheckoutConnectorFacade
            ->getBlacklistedCountryCollectionByQuote($quoteTransfer);
    }
}
