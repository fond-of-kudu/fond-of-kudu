<?php

namespace FondOfKudu\Zed\Quote\Business;

use FondOfKudu\Zed\Quote\Business\SuccessOrderQuote\SuccessOrderQuoteDeleter;
use FondOfKudu\Zed\Quote\Business\SuccessOrderQuote\SuccessOrderQuoteDeleterInterface;
use Spryker\Zed\Quote\Business\QuoteBusinessFactory as SprykerQuoteBusinessFactory;

/**
 * @method \Spryker\Zed\Quote\Persistence\QuoteEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\Quote\Persistence\QuoteRepositoryInterface|\FondOfKudu\Zed\Quote\Persistence\QuoteRepositoryInterface getRepository()
 * @method \Spryker\Zed\Quote\QuoteConfig|\FondOfKudu\Zed\Quote\QuoteConfig getConfig()
 */
class QuoteBusinessFactory extends SprykerQuoteBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\Quote\Business\SuccessOrderQuote\SuccessOrderQuoteDeleterInterface
     */
    public function createSuccessOrderQuoteDeleter(): SuccessOrderQuoteDeleterInterface
    {
        return new SuccessOrderQuoteDeleter(
            $this->getEntityManager(),
            $this->getRepository(),
            $this->getConfig(),
            $this->getQuoteDeleteBeforePlugins(),
        );
    }
}
