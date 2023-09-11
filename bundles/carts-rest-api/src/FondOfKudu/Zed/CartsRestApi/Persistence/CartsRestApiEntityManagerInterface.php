<?php

namespace FondOfKudu\Zed\CartsRestApi\Persistence;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SpyQuoteEntityTransfer;
use Spryker\Zed\CartsRestApi\Persistence\CartsRestApiEntityManagerInterface as SprykerCartsRestApiEntityManagerInterface;

interface CartsRestApiEntityManagerInterface extends SprykerCartsRestApiEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    public function changeCustomerQuoteToGuestQuote(QuoteTransfer $quoteTransfer): bool;

    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\SpyQuoteEntityTransfer|null
     */
    public function getQuoteByOrderReference(string $orderReference): ?SpyQuoteEntityTransfer;
}
