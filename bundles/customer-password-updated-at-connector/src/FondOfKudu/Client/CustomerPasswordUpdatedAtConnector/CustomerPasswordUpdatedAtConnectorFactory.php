<?php

namespace FondOfKudu\Client\CustomerPasswordUpdatedAtConnector;

use FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Dependency\Client\CustomerPasswordUpdatedAtConnectorToZedRequestClientInterface;
use FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Zed\CustomerPasswordUpdatedAtConnectorStub;
use FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Zed\CustomerPasswordUpdatedAtConnectorStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CustomerPasswordUpdatedAtConnectorFactory extends AbstractFactory
{
    /**
     * @return \FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Zed\CustomerPasswordUpdatedAtConnectorStubInterface
     */
    public function createZedCustomerStub(): CustomerPasswordUpdatedAtConnectorStubInterface
    {
        return new CustomerPasswordUpdatedAtConnectorStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Dependency\Client\CustomerPasswordUpdatedAtConnectorToZedRequestClientInterface
     */
    protected function getZedRequestClient(): CustomerPasswordUpdatedAtConnectorToZedRequestClientInterface
    {
        return $this->getProvidedDependency(CustomerPasswordUpdatedAtConnectorDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
