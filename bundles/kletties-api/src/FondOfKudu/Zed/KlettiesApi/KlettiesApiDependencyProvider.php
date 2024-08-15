<?php

namespace FondOfKudu\Zed\KlettiesApi;

use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeBridge;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeInterface;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeBridge;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeInterface;
use FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer\KlettiesApiToApiQueryBuilderContainerBridge;
use FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer\KlettiesApiToApiQueryBuilderContainerInterface;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class KlettiesApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_API = 'KLETTIES:QUERY_CONTAINER_API';

    /**
     * @var string
     */
    public const QUERY_BUILDER_CONTAINER_API = 'KLETTIES:QUERY_BUILDER_CONTAINER_API';

    /**
     * @var string
     */
    public const FACADE_KLETTIES = 'KLETTIES:FACADE_KLETTIES';

    /**
     * @var string
     */
    public const QUERY_KLETTIES_ORDER = 'KLETTIES:QUERY_KLETTIES_ORDER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addApiFacade($container);

        return $this->addKlettiesFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        $container = $this->addApiQueryBuilderContainer($container);
        $container = $this->addApiFacade($container);
        $container = $this->addKlettiesFacade($container);

        return $this->addKlettiesOrderQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addApiFacade(Container $container): Container
    {
        $container[static::FACADE_API] = static function (Container $container): KlettiesApiToApiFacadeInterface {
            return new KlettiesApiToApiFacadeBridge($container->getLocator()->api()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addApiQueryBuilderContainer(Container $container): Container
    {
        $container[static::QUERY_BUILDER_CONTAINER_API] = static function (Container $container): KlettiesApiToApiQueryBuilderContainerInterface {
            return new KlettiesApiToApiQueryBuilderContainerBridge($container->getLocator()->apiQueryBuilder()->queryContainer());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addKlettiesFacade(Container $container): Container
    {
        $container[static::FACADE_KLETTIES] = static function (Container $container): KlettiesApiToKlettiesFacadeInterface {
            return new KlettiesApiToKlettiesFacadeBridge($container->getLocator()->kletties()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addKlettiesOrderQuery(Container $container): Container
    {
        $self = $this;
        $container[static::QUERY_KLETTIES_ORDER] = static function () use ($self): FokKlettiesOrderQuery {
            return $self->createKlettiesOrderQuery();
        };

        return $container;
    }

    /**
     * @return \Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery
     */
    protected function createKlettiesOrderQuery(): FokKlettiesOrderQuery
    {
        return FokKlettiesOrderQuery::create();
    }
}
