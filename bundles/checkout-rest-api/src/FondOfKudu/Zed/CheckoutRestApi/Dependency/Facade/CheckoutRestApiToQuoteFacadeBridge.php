<?php

namespace FondOfKudu\Zed\CheckoutRestApi\Dependency\Facade;

use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\CheckoutRestApi\Dependency\Facade\CheckoutRestApiToQuoteFacadeBridge as SprykerCheckoutRestApiToQuoteFacadeBridge;

class CheckoutRestApiToQuoteFacadeBridge extends SprykerCheckoutRestApiToQuoteFacadeBridge implements CheckoutRestApiToQuoteFacadeInterface
{
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
