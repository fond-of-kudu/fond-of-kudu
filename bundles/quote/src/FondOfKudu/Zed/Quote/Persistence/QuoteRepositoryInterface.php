<?php

namespace FondOfKudu\Zed\Quote\Persistence;

use DateTime;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Spryker\Zed\Quote\Persistence\QuoteRepositoryInterface as SprykerQuoteRepositoryInterface;

interface QuoteRepositoryInterface extends SprykerQuoteRepositoryInterface
{
    /**
     * @param string $customerReferencePrefix
     * @param \DateTime $lifetimeLimitDate
     * @param int $limit
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function findExpiredGuestPrefixQuotes(string $customerReferencePrefix, DateTime $lifetimeLimitDate, int $limit): QuoteCollectionTransfer;

    /**
     * @param \DateTime $lifetimeLimitDate
     * @param int $limit
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function findExpiredSuccessOrderQuotes(DateTime $lifetimeLimitDate, int $limit): QuoteCollectionTransfer;
}
