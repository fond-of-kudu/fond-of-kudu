<?php

namespace FondOfKudu\Client\CartsRestApi\Zed;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Client\CartsRestApi\Zed\CartsRestApiZedStub as SprykerCartsRestApiZedStub;

class CartsRestApiZedStub extends SprykerCartsRestApiZedStub implements CartsRestApiZedStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function resetQuote(QuoteTransfer $quoteTransfer): QuoteResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\QuoteResponseTransfer $quoteResponseTransfer */
        $quoteResponseTransfer = $this->zedRequestClient->call('/carts-rest-api/gateway/reset-quote', $quoteTransfer);

        return $quoteResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function getQuoteByOrderReference(OrderTransfer $orderTransfer): QuoteResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\QuoteResponseTransfer $quoteResponseTransfer */
        $quoteResponseTransfer = $this->zedRequestClient->call('/carts-rest-api/gateway/get-quote-by-order-reference', $orderTransfer);

        return $quoteResponseTransfer;
    }
}
