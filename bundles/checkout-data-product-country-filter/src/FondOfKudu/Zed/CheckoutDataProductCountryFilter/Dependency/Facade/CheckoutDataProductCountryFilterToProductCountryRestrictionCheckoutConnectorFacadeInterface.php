<?php

namespace FondOfKudu\Zed\CheckoutDataProductCountryFilter\Dependency\Facade;

use Generated\Shared\Transfer\BlacklistedCountryCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeInterface
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
