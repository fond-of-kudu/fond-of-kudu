<?php

namespace FondOfKudu\Zed\CartsRestApi\Dependency\Facade;

use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SpyQuoteEntityTransfer;
use Spryker\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToQuoteFacadeBridge as SprykerCartsRestApiToQuoteFacadeBridge;

class CartsRestApiToQuoteFacadeBridge extends SprykerCartsRestApiToQuoteFacadeBridge implements CartsRestApiToQuoteFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\SpyQuoteEntityTransfer $quoteEntityTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function mapQuoteTransfer(SpyQuoteEntityTransfer $quoteEntityTransfer): QuoteTransfer
    {
        return $this->quoteFacade->mapQuoteTransfer($quoteEntityTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function updateQuote(QuoteTransfer $quoteTransfer): QuoteResponseTransfer
    {
        return $this->quoteFacade->updateQuote($quoteTransfer);
    }
}
