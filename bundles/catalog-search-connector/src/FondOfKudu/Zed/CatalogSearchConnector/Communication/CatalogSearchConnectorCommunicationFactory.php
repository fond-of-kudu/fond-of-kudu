<?php

namespace FondOfKudu\Zed\CatalogSearchConnector\Communication;

use FondOfKudu\Zed\CatalogSearchConnector\CatalogSearchConnectorDependencyProvider;
use FondOfKudu\Zed\CatalogSearchConnector\Dependency\Facade\CatalogSearchConnectorToAvailabilityFacadeInterface;
use FondOfKudu\Zed\CatalogSearchConnector\Dependency\Facade\CatalogSearchConnectorToStoreFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class CatalogSearchConnectorCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfKudu\Zed\CatalogSearchConnector\Dependency\Facade\CatalogSearchConnectorToStoreFacadeInterface
     */
    public function getStoreFacade(): CatalogSearchConnectorToStoreFacadeInterface
    {
        return $this->getProvidedDependency(CatalogSearchConnectorDependencyProvider::FACADE_STORE);
    }

    /**
     * @return \FondOfKudu\Zed\CatalogSearchConnector\Dependency\Facade\CatalogSearchConnectorToAvailabilityFacadeInterface
     */
    public function getAvailabilityFacade(): CatalogSearchConnectorToAvailabilityFacadeInterface
    {
        return $this->getProvidedDependency(CatalogSearchConnectorDependencyProvider::FACADE_AVAILABILITY);
    }
}
