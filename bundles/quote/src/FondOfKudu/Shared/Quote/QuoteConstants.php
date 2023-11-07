<?php

namespace FondOfKudu\Shared\Quote;

use Spryker\Shared\Quote\QuoteConstants as SprykerQuoteConstants;

interface QuoteConstants extends SprykerQuoteConstants
{
    /**
     * @var string
     */
    public const SUCCESS_ORDER_QUOTE_LIFETIME = 'FOND_OF_KUDU:QUOTE:SUCCESS_ORDER_QUOTE_LIFETIME';

    /**
     * @var string
     */
    public const BATCH_SIZE_LIMIT = 'FOND_OF_KUDU:QUOTE:BATCH_SIZE_LIMIT';

    /**
     * @var string
     */
    public const GUEST_CUSTOMER_REFERENCE_PREFIX = 'FOND_OF_KUDU:QUOTE:GUEST_CUSTOMER_REFERENCE_PREFIX';
}
