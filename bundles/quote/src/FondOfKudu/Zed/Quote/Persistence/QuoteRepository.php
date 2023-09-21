<?php

namespace FondOfKudu\Zed\Quote\Persistence;

use DateTime;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Quote\Persistence\Map\SpyQuoteTableMap;
use Orm\Zed\Quote\Persistence\SpyQuoteQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria as SprykerCriteria;
use Spryker\Zed\Quote\Persistence\QuoteRepository as SprykerQuoteRepository;

/**
 * @method \Spryker\Zed\Quote\Persistence\QuotePersistenceFactory getFactory()
 */
class QuoteRepository extends SprykerQuoteRepository implements QuoteRepositoryInterface
{
    /**
     * @param string $customerReferencePrefix
     * @param \DateTime $lifetimeLimitDate
     * @param int $limit
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    public function findExpiredGuestPrefixQuotes(string $customerReferencePrefix, DateTime $lifetimeLimitDate, int $limit): QuoteCollectionTransfer
    {
        $quoteQuery = $this->getFactory()
            ->createQuoteQuery()
            ->joinWithSpyStore()
            ->addJoin(SpyQuoteTableMap::COL_CUSTOMER_REFERENCE, SpyCustomerTableMap::COL_CUSTOMER_REFERENCE, SprykerCriteria::LEFT_JOIN)
            ->filterByUpdatedAt(['max' => $lifetimeLimitDate], Criteria::LESS_EQUAL)
            ->filterByCustomerReference_Like(sprintf('%s%%', $customerReferencePrefix))
            ->orderByUpdatedAt()
            ->limit($limit);

        return $this->createQuoteCollection($quoteQuery);
    }

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

        return $this->createQuoteCollection($quoteQuery);
    }

    /**
     * @param \Orm\Zed\Quote\Persistence\SpyQuoteQuery $quoteQuery
     *
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    protected function createQuoteCollection(SpyQuoteQuery $quoteQuery): QuoteCollectionTransfer
    {
        $quoteEntityCollectionTransfer = $this->buildQueryFromCriteria($quoteQuery)->find();

        $quoteMapper = $this->getFactory()->createQuoteMapper();
        $quoteCollectionTransfer = new QuoteCollectionTransfer();
        foreach ($quoteEntityCollectionTransfer as $quoteEntityTransfer) {
            $quoteCollectionTransfer->addQuote($quoteMapper->mapQuoteTransfer($quoteEntityTransfer));
        }

        return $quoteCollectionTransfer;
    }
}
