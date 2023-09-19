<?php

namespace FondOfKudu\Zed\Quote;

use FondOfKudu\Shared\Quote\QuoteConstants;
use Spryker\Zed\Quote\QuoteConfig as SprykerQuoteConfig;

class QuoteConfig extends SprykerQuoteConfig
{
    /**
     * @var string
     */
    protected const DEFAULT_SUCCESS_ORDER_QUOTE_LIFETIME = 'P02D';

    /**
     * @return string
     */
    public function getSuccessOrderQuoteLifeTime(): string
    {
        return $this->get(QuoteConstants::SUCCESS_ORDER_QUOTE_LIFETIME, static::DEFAULT_SUCCESS_ORDER_QUOTE_LIFETIME);
    }
}
