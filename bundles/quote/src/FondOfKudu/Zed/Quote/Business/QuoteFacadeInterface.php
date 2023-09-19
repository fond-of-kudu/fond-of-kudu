<?php

namespace FondOfKudu\Zed\Quote\Business;

use Spryker\Zed\Quote\Business\QuoteFacadeInterface as SprykerQuoteFacadeInterface;

interface QuoteFacadeInterface extends SprykerQuoteFacadeInterface
{
    /**
     * @return void
     */
    public function deleteExpiredSuccessOrderQuote(): void;
}
