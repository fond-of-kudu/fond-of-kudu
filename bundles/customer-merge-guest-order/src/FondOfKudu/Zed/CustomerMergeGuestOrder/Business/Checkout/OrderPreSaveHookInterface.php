<?php

namespace FondOfKudu\Zed\CustomerMergeGuestOrder\Business\Checkout;

use Generated\Shared\Transfer\QuoteTransfer;

interface OrderPreSaveHookInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function updateCustomerReference(QuoteTransfer $quoteTransfer): QuoteTransfer;
}
