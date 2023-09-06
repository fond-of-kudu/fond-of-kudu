<?php

namespace FondOfKudu\Client\CartsRestApi;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Client\CartsRestApi\CartsRestApiClient as SprykerCartsRestApiClient;

/**
 * @method \FondOfKudu\Client\CartsRestApi\CartsRestApiFactory getFactory()
 */
class CartsRestApiClient extends SprykerCartsRestApiClient implements CartsRestApiClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function resetQuote(QuoteTransfer $quoteTransfer): QuoteResponseTransfer
    {
        return $this->getFactory()
            ->createCartsRestApiZedStub()
            ->resetQuote($quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function getQuoteByOrderReference(OrderTransfer $orderTransfer): QuoteResponseTransfer
    {
        return $this->getFactory()
            ->createCartsRestApiZedStub()
            ->getQuoteByOrderReference($orderTransfer);
    }
}
