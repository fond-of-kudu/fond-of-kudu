<?php

namespace FondOfKudu\Zed\CartsRestApi\Communication\Controller;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\CartsRestApi\Communication\Controller\GatewayController as SprykerGatewayController;

/**
 * @method \FondOfKudu\Zed\CartsRestApi\Business\CartsRestApiFacadeInterface getFacade()
 */
class GatewayController extends SprykerGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function resetQuoteAction(QuoteTransfer $quoteTransfer): QuoteResponseTransfer
    {
        return $this->getFacade()->resetQuote($quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function getQuoteByOrderReferenceAction(OrderTransfer $orderTransfer): QuoteResponseTransfer
    {
        return $this->getFacade()->getQuoteByOrderReference($orderTransfer);
    }
}
