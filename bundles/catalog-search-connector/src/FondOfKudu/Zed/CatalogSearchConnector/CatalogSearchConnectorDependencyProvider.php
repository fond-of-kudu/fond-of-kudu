<?php

namespace FondOfKudu\Zed\CatalogSearchConnector;

use FondOfKudu\Zed\CatalogSearchConnector\Dependency\Facade\CatalogSearchConnectorToAvailabilityFacadeBridge;
use FondOfKudu\Zed\CatalogSearchConnector\Dependency\Facade\CatalogSearchConnectorToAvailabilityFacadeInterface;
use FondOfKudu\Zed\CatalogSearchConnector\Dependency\Facade\CatalogSearchConnectorToStoreFacadeBridge;
use FondOfKudu\Zed\CatalogSearchConnector\Dependency\Facade\CatalogSearchConnectorToStoreFacadeInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CatalogSearchConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @var string
     */
    public const FACADE_AVAILABILITY = 'FACADE_AVAILABILITY';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = $this->addStoreFacade($container);
        $container = $this->addAvailabilityFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container->set(static::FACADE_STORE, static fn (Container $container): CatalogSearchConnectorToStoreFacadeInterface => new CatalogSearchConnectorToStoreFacadeBridge(
            $container->getLocator()->store()->facade(),
        ));

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAvailabilityFacade(Container $container): Container
    {
        $container->set(static::FACADE_AVAILABILITY, static fn (Container $container): CatalogSearchConnectorToAvailabilityFacadeInterface => new CatalogSearchConnectorToAvailabilityFacadeBridge(
            $container->getLocator()->availability()->facade(),
        ));

        return $container;
    }
}
