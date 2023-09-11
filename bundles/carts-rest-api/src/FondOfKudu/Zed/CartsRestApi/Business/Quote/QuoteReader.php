<?php

namespace FondOfKudu\Zed\CartsRestApi\Business\Quote;

use FondOfKudu\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToQuoteFacadeInterface;
use FondOfKudu\Zed\CartsRestApi\Persistence\CartsRestApiEntityManagerInterface;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Spryker\Zed\CartsRestApi\Business\PermissionChecker\QuotePermissionCheckerInterface;
use Spryker\Zed\CartsRestApi\Business\Quote\QuoteReader as SprykerQuoteReader;
use Spryker\Zed\CartsRestApi\Business\Reloader\QuoteReloaderInterface;
use Spryker\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToStoreFacadeInterface;

class QuoteReader extends SprykerQuoteReader implements QuoteReaderInterface
{
    /**
     * @var \FondOfKudu\Zed\CartsRestApi\Persistence\CartsRestApiEntityManagerInterface
     */
    protected CartsRestApiEntityManagerInterface $cartsRestApiEntityManager;

    /**
     * @var \FondOfKudu\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToQuoteFacadeInterface
     */
    protected $quoteFacade;

    /**
     * @param \FondOfKudu\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToQuoteFacadeInterface $quoteFacade
     * @param \Spryker\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToStoreFacadeInterface $storeFacade
     * @param \Spryker\Zed\CartsRestApi\Business\PermissionChecker\QuotePermissionCheckerInterface $quotePermissionChecker
     * @param \Spryker\Zed\CartsRestApi\Business\Reloader\QuoteReloaderInterface $quoteReloader
     * @param \FondOfKudu\Zed\CartsRestApi\Persistence\CartsRestApiEntityManagerInterface $cartsRestApiEntityManager
     * @param array $quoteCollectionExpanderPlugins
     * @param array $quoteExpanderPlugins
     */
    public function __construct(
        CartsRestApiToQuoteFacadeInterface $quoteFacade,
        CartsRestApiToStoreFacadeInterface $storeFacade,
        QuotePermissionCheckerInterface $quotePermissionChecker,
        QuoteReloaderInterface $quoteReloader,
        CartsRestApiEntityManagerInterface $cartsRestApiEntityManager,
        array $quoteCollectionExpanderPlugins,
        array $quoteExpanderPlugins
    ) {
        parent::__construct($quoteFacade, $storeFacade, $quotePermissionChecker, $quoteReloader, $quoteCollectionExpanderPlugins, $quoteExpanderPlugins);
        $this->cartsRestApiEntityManager = $cartsRestApiEntityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function getQuoteByOrderReference(OrderTransfer $orderTransfer): QuoteResponseTransfer
    {
        $orderTransfer->requireOrderReference();

        $spyQuoteEntityTransfer = $this->cartsRestApiEntityManager->getQuoteByOrderReference($orderTransfer->getOrderReference());

        if (!$spyQuoteEntityTransfer) {
            return (new QuoteResponseTransfer())->setIsSuccessful(false);
        }

        return (new QuoteResponseTransfer())->setIsSuccessful(true)
            ->setQuote($this->quoteFacade->mapQuoteTransfer($spyQuoteEntityTransfer));
    }
}
