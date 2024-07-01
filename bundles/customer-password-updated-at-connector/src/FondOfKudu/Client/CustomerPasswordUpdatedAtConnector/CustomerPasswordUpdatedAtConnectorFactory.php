<?php

namespace FondOfKudu\Client\CustomerPasswordUpdatedAtConnector;

use FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Zed\CustomerPasswordUpdatedAtConnectorStub;
use FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Zed\CustomerPasswordUpdatedAtConnectorStubInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

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
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(CustomerPasswordUpdatedAtConnectorDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
