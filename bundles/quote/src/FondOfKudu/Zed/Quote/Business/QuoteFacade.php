<?php

namespace FondOfKudu\Zed\Quote\Business;

use Spryker\Zed\Quote\Business\QuoteFacade as SprykerQuoteFacade;

/**
 * @method \FondOfKudu\Zed\Quote\Business\QuoteBusinessFactory getFactory()
 * @method \Spryker\Zed\Quote\Persistence\QuoteRepositoryInterface getRepository()
 * @method \Spryker\Zed\Quote\Persistence\QuoteEntityManagerInterface getEntityManager()
 */
class QuoteFacade extends SprykerQuoteFacade implements QuoteFacadeInterface
{
    /**
     * @return void
     */
    public function deleteExpiredSuccessOrderQuote(): void
    {
        $this->getFactory()->createSuccessOrderQuoteDeleter()->deleteExpiredSuccessOrderQuote();
    }
}
