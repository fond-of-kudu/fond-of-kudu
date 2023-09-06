<?php

namespace FondOfKudu\Zed\CartsRestApi\Business\Quote;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Spryker\Zed\CartsRestApi\Business\Quote\QuoteReaderInterface as SprykerQuoteReaderInterface;

interface QuoteReaderInterface extends SprykerQuoteReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function getQuoteByOrderReference(OrderTransfer $orderTransfer): QuoteResponseTransfer;
}
