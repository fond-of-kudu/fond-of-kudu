<?php

namespace FondOfKudu\Zed\Quote\Business\SuccessOrderQuote;

interface SuccessOrderQuoteDeleterInterface
{
    /**
     * @return void
     */
    public function deleteExpiredSuccessOrderQuote(): void;
}
