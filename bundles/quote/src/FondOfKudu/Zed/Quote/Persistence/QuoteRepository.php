<?php

namespace FondOfKudu\Zed\Quote\Persistence;

use DateTime;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Quote\Persistence\Map\SpyQuoteTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Quote\Persistence\QuoteRepository as SprykerQuoteRepository;

class QuoteRepository extends SprykerQuoteRepository implements QuoteRepositoryInterface
{
    /**
     * @param \DateTime $lifetimeLimitDate
     * @param int $limit
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function findExpiredSuccessOrderQuotes(DateTime $lifetimeLimitDate, int $limit): QuoteCollectionTransfer
    {
        $quoteQuery = $this->getFactory()
            ->createQuoteQuery()
            ->joinWithSpyStore()
            ->addJoin(SpyQuoteTableMap::COL_CUSTOMER_REFERENCE, SpyCustomerTableMap::COL_CUSTOMER_REFERENCE, Criteria::LEFT_JOIN)
            ->filterByUpdatedAt(['max' => $lifetimeLimitDate], Criteria::LESS_EQUAL)
            ->where(SpyQuoteTableMap::COL_ORDER_REFERENCE . Criteria::ISNOTNULL)
            ->orderByUpdatedAt()
            ->limit($limit);

        $quoteEntityCollectionTransfer = $this->buildQueryFromCriteria($quoteQuery)->find();

        $quoteMapper = $this->getFactory()->createQuoteMapper();
        $quoteCollectionTransfer = new QuoteCollectionTransfer();
        foreach ($quoteEntityCollectionTransfer as $quoteEntityTransfer) {
            $quoteCollectionTransfer->addQuote($quoteMapper->mapQuoteTransfer($quoteEntityTransfer));
        }

        return $quoteCollectionTransfer;
    }
}
