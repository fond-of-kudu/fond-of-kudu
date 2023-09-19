<?php

namespace FondOfKudu\Zed\Quote\Business\GuestQuote;

interface GuestPrefixQuoteDeleterInterface
{
    /**
     * @return void
     */
    public function deleteExpiredGuestPrefixQuote(): void;
}
