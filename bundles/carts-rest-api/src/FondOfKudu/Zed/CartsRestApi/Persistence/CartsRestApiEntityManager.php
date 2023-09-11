<?php

namespace FondOfKudu\Zed\CartsRestApi\Persistence;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SpyQuoteEntityTransfer;
use Generated\Shared\Transfer\SpyStoreEntityTransfer;
use Spryker\Zed\CartsRestApi\Persistence\CartsRestApiEntityManager as SprykerCartsRestApiEntityManager;

/**
 * @method \FondOfKudu\Zed\CartsRestApi\Persistence\CartsRestApiPersistenceFactory getFactory()
 */
class CartsRestApiEntityManager extends SprykerCartsRestApiEntityManager implements CartsRestApiEntityManagerInterface
{
    /**
     * @var string
     */
    public const COLUMN_CUSTOMER_REFERENCE = 'CustomerReference';

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    public function changeCustomerQuoteToGuestQuote(QuoteTransfer $quoteTransfer): bool
    {
        $quoteTransfer->requireCustomerReference()
            ->requireCartCustomerReference()
            ->requireUuid();

        $updatedRows = $this->getFactory()->getQuoteQuery()
            ->filterByCustomerReference($quoteTransfer->getCustomerReference())
            ->filterByUuid($quoteTransfer->getUuid())
            ->update([
                static::COLUMN_CUSTOMER_REFERENCE => $quoteTransfer->getCartCustomerReference(),
            ]);

        return $updatedRows > 0;
    }

    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\SpyQuoteEntityTransfer|null
     */
    public function getQuoteByOrderReference(string $orderReference): ?SpyQuoteEntityTransfer
    {
        $quote = $this->getFactory()->getQuoteQuery()
            ->filterByOrderReference($orderReference)
            ->innerJoinWithSpyStore()
            ->findOne();

        if (!$quote) {
            return null;
        }

        $spyQuoteEntityTransfer = (new SpyQuoteEntityTransfer())->fromArray($quote->toArray(), true);
        $spyStoreEntityTransfer = (new SpyStoreEntityTransfer())->fromArray($quote->getSpyStore()->toArray(), true);

        return $spyQuoteEntityTransfer->setSpyStore($spyStoreEntityTransfer);
    }
}
