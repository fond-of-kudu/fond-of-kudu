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
     * @var int
     */
    protected const DEFAULT_BATCH_SIZE_LIMIT = 200;

    /**
     * @return string
     */
    public function getSuccessOrderQuoteLifeTime(): string
    {
        return $this->get(QuoteConstants::SUCCESS_ORDER_QUOTE_LIFETIME, static::DEFAULT_SUCCESS_ORDER_QUOTE_LIFETIME);
    }

    /**
     * @return int
     */
    public function getBatchSizeLimit(): int
    {
        return $this->get(QuoteConstants::BATCH_SIZE_LIMIT, static::DEFAULT_BATCH_SIZE_LIMIT);
    }
}
