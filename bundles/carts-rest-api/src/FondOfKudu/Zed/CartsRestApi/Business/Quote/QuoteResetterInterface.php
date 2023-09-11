<?php

namespace FondOfKudu\Zed\CartsRestApi\Business\Quote;

use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface QuoteResetterInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function resetQuote(QuoteTransfer $quoteTransfer): QuoteResponseTransfer;
}
