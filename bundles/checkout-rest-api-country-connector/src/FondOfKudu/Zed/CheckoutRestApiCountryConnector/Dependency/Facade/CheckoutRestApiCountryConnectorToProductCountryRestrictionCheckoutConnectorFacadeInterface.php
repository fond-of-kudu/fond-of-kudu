<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade;

use Generated\Shared\Transfer\BlacklistedCountryCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface CheckoutRestApiCountryConnectorToProductCountryRestrictionCheckoutConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\BlacklistedCountryCollectionTransfer
     */
    public function getBlacklistedCountryCollectionByQuote(
        QuoteTransfer $quoteTransfer
    ): BlacklistedCountryCollectionTransfer;
}
