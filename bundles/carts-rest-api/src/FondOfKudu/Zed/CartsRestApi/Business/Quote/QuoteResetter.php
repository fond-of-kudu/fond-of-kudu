<?php

namespace FondOfKudu\Zed\CartsRestApi\Business\Quote;

use ArrayObject;
use FondOfKudu\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToQuoteFacadeInterface;
use FondOfKudu\Zed\CartsRestApi\Persistence\CartsRestApiEntityManagerInterface;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class QuoteResetter implements QuoteResetterInterface
{
    /**
     * @var \FondOfKudu\Zed\CartsRestApi\Persistence\CartsRestApiEntityManagerInterface
     */
    protected CartsRestApiEntityManagerInterface $quoteEntityManager;

    /**
     * @var \FondOfKudu\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToQuoteFacadeInterface
     */
    protected CartsRestApiToQuoteFacadeInterface $quoteFacade;

    /**
     * @param \FondOfKudu\Zed\CartsRestApi\Persistence\CartsRestApiEntityManagerInterface $quoteEntityManager
     * @param \FondOfKudu\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToQuoteFacadeInterface $quoteFacade
     */
    public function __construct(
        CartsRestApiEntityManagerInterface $quoteEntityManager,
        CartsRestApiToQuoteFacadeInterface $quoteFacade
    ) {
        $this->quoteEntityManager = $quoteEntityManager;
        $this->quoteFacade = $quoteFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function resetQuote(QuoteTransfer $quoteTransfer): QuoteResponseTransfer
    {
        if (
            $quoteTransfer->getCartCustomerReference() !== null &&
            $quoteTransfer->getCustomerReference() !== null &&
            $quoteTransfer->getCustomerReference() !== $quoteTransfer->getCartCustomerReference()
        ) {
            $isSuccess = $this->quoteEntityManager->changeCustomerQuoteToGuestQuote($quoteTransfer);

            if ($isSuccess) {
                $quoteTransfer->setCustomerReference($quoteTransfer->getCartCustomerReference())
                    ->setCartCustomerReference(null);
            }
        }

        $singleQuantityItemTransfers = $quoteTransfer->getItems();
        $multiplyQuantityItemTransfers = [];

        foreach ($singleQuantityItemTransfers as $singleQuantityItemTransfer) {
            if (isset($multiplyQuantityItemTransfers[$singleQuantityItemTransfer->getSku()])) {
                /** @var \Generated\Shared\Transfer\ItemTransfer $multiplyQuantityItemTransfer */
                $multiplyQuantityItemTransfer = $multiplyQuantityItemTransfers[$singleQuantityItemTransfer->getSku()];

                $multiplyQuantityItemTransfer->setQuantity($multiplyQuantityItemTransfer->getQuantity() + 1);

                $multiplyQuantityItemTransfers[$singleQuantityItemTransfer->getSku()] = $multiplyQuantityItemTransfer;

                continue;
            }

            $singleQuantityItemTransfer->setIdOrderItem(null)
                ->setIdSalesOrderItem(null)
                ->setFkOmsOrderItemState(null)
                ->setFkSalesOrder(null)
                ->setProcess(null);

            $multiplyQuantityItemTransfers[$singleQuantityItemTransfer->getSku()] = $singleQuantityItemTransfer;
        }

        $quoteTransfer->setOrderReference(null);
        $quoteTransfer->setItems(new ArrayObject(array_values($multiplyQuantityItemTransfers)));

        return $this->quoteFacade->updateQuote($quoteTransfer);
    }
}
