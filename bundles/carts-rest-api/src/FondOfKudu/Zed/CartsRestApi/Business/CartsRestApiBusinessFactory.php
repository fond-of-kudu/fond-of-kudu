<?php

namespace FondOfKudu\Zed\CartsRestApi\Business;

use FondOfKudu\Zed\CartsRestApi\Business\PermissionChecker\QuotePermissionChecker;
use FondOfKudu\Zed\CartsRestApi\Business\Quote\QuoteReader;
use FondOfKudu\Zed\CartsRestApi\Business\Quote\QuoteReaderInterface;
use FondOfKudu\Zed\CartsRestApi\Business\Quote\QuoteResetter;
use FondOfKudu\Zed\CartsRestApi\Business\Quote\QuoteResetterInterface;
use FondOfKudu\Zed\CartsRestApi\CartsRestApiDependencyProvider;
use FondOfKudu\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToQuoteFacadeInterface;
use Spryker\Zed\CartsRestApi\Business\CartsRestApiBusinessFactory as SprykerCartsRestApiBusinessFactory;
use Spryker\Zed\CartsRestApi\Business\PermissionChecker\QuotePermissionCheckerInterface;

/**
 * @method \FondOfKudu\Zed\CartsRestApi\Persistence\CartsRestApiEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\CartsRestApi\CartsRestApiConfig getConfig()
 */
class CartsRestApiBusinessFactory extends SprykerCartsRestApiBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\CartsRestApi\Business\Quote\QuoteReaderInterface
     */
    public function createQuoteReader(): QuoteReaderInterface
    {
        return new QuoteReader(
            $this->getQuoteFacade(),
            $this->getStoreFacade(),
            $this->createQuotePermissionChecker(),
            $this->createQuoteReloader(),
            $this->getEntityManager(),
            $this->getQuoteCollectionExpanderPlugins(),
            $this->getQuoteExpanderPlugins(),
        );
    }

    /**
     * @return \FondOfKudu\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToQuoteFacadeInterface
     */
    public function getQuoteFacade(): CartsRestApiToQuoteFacadeInterface
    {
        return $this->getProvidedDependency(CartsRestApiDependencyProvider::FACADE_QUOTE);
    }

    /**
     * @return \FondOfKudu\Zed\CartsRestApi\Business\Quote\QuoteResetterInterface
     */
    public function createQuoteResetter(): QuoteResetterInterface
    {
        return new QuoteResetter(
            $this->getEntityManager(),
            $this->getQuoteFacade(),
        );
    }

    /**
     * @return \Spryker\Zed\CartsRestApi\Business\PermissionChecker\QuotePermissionCheckerInterface
     */
    public function createQuotePermissionChecker(): QuotePermissionCheckerInterface
    {
        return new QuotePermissionChecker();
    }
}
