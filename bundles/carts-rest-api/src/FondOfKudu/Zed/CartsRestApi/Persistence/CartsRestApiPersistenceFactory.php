<?php

namespace FondOfKudu\Zed\CartsRestApi\Persistence;

use FondOfKudu\Zed\CartsRestApi\CartsRestApiDependencyProvider;
use FondOfKudu\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToQuoteFacadeInterface;
use Spryker\Zed\CartsRestApi\Persistence\CartsRestApiPersistenceFactory as SprykerCartsRestApiPersistenceFactory;

/**
 * @method \FondOfKudu\Zed\CartsRestApi\Persistence\CartsRestApiEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\CartsRestApi\CartsRestApiConfig getConfig()
 */
class CartsRestApiPersistenceFactory extends SprykerCartsRestApiPersistenceFactory
{
    /**
     * @return \FondOfKudu\Zed\CartsRestApi\Dependency\Facade\CartsRestApiToQuoteFacadeInterface
     */
    public function getQuoteFacade(): CartsRestApiToQuoteFacadeInterface
    {
        return $this->getProvidedDependency(CartsRestApiDependencyProvider::FACADE_QUOTE);
    }
}
