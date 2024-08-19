<?php

namespace FondOfKudu\Zed\KlettiesApi\Persistence;

use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeInterface;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeInterface;
use FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer\KlettiesApiToApiQueryBuilderContainerInterface;
use FondOfKudu\Zed\KlettiesApi\KlettiesApiDependencyProvider;
use FondOfKudu\Zed\KlettiesApi\Persistence\Propel\Mapper\TransferMapper;
use FondOfKudu\Zed\KlettiesApi\Persistence\Propel\Mapper\TransferMapperInterface;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfKudu\Zed\KlettiesApi\Persistence\KlettiesApiRepositoryInterface getRepository()
 */
class KlettiesApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \FondOfKudu\Zed\KlettiesApi\Persistence\Propel\Mapper\TransferMapperInterface
     */
    public function createTransferMapper(): TransferMapperInterface
    {
        return new TransferMapper();
    }

    /**
     * @return \Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery
     */
    public function getKlettiesOrderQuery(): FokKlettiesOrderQuery
    {
        return $this->getProvidedDependency(KlettiesApiDependencyProvider::QUERY_KLETTIES_ORDER);
    }

    /**
     * @return \FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer\KlettiesApiToApiQueryBuilderContainerInterface
     */
    public function getQueryBuilderContainer(): KlettiesApiToApiQueryBuilderContainerInterface
    {
        return $this->getProvidedDependency(KlettiesApiDependencyProvider::QUERY_BUILDER_CONTAINER_API);
    }

    /**
     * @return \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeInterface
     */
    public function getApiFacade(): KlettiesApiToApiFacadeInterface
    {
        return $this->getProvidedDependency(KlettiesApiDependencyProvider::FACADE_API);
    }

    /**
     * @return \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeInterface
     */
    public function getKlettiesFacade(): KlettiesApiToKlettiesFacadeInterface
    {
        return $this->getProvidedDependency(KlettiesApiDependencyProvider::FACADE_KLETTIES);
    }
}
