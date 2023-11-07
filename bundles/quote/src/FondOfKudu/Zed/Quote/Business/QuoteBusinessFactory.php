<?php

namespace FondOfKudu\Zed\Quote\Business;

use FondOfKudu\Zed\Quote\Business\GuestQuote\GuestPrefixQuoteDeleter;
use FondOfKudu\Zed\Quote\Business\GuestQuote\GuestPrefixQuoteDeleterInterface;
use FondOfKudu\Zed\Quote\Business\SuccessOrderQuote\SuccessOrderQuoteDeleter;
use FondOfKudu\Zed\Quote\Business\SuccessOrderQuote\SuccessOrderQuoteDeleterInterface;
use Spryker\Zed\Quote\Business\QuoteBusinessFactory as SprykerQuoteBusinessFactory;

/**
 * @method \Spryker\Zed\Quote\Persistence\QuoteEntityManagerInterface getEntityManager()
 * @method \FondOfKudu\Zed\Quote\Persistence\QuoteRepositoryInterface getRepository()
 * @method \FondOfKudu\Zed\Quote\QuoteConfig getConfig()
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

    /**
     * @return \FondOfKudu\Zed\Quote\Business\GuestQuote\GuestPrefixQuoteDeleterInterface
     */
    public function createGuestPrefixQuoteDelete(): GuestPrefixQuoteDeleterInterface
    {
        return new GuestPrefixQuoteDeleter(
            $this->getEntityManager(),
            $this->getRepository(),
            $this->getConfig(),
            $this->getQuoteDeleteBeforePlugins(),
        );
    }
}
