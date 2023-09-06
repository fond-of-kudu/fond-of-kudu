<?php

namespace FondOfKudu\Zed\CartsRestApi\Business;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\CartsRestApi\Business\CartsRestApiFacade as SprykerCartsRestApiFacade;

/**
 * @method \FondOfKudu\Zed\CartsRestApi\Business\CartsRestApiBusinessFactory getFactory()
 */
class CartsRestApiFacade extends SprykerCartsRestApiFacade implements CartsRestApiFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function resetQuote(QuoteTransfer $quoteTransfer): QuoteResponseTransfer
    {
        return $this->getFactory()->createQuoteResetter()->resetQuote($quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function getQuoteByOrderReference(OrderTransfer $orderTransfer): QuoteResponseTransfer
    {
        return $this->getFactory()->createQuoteReader()->getQuoteByOrderReference($orderTransfer);
    }
}
