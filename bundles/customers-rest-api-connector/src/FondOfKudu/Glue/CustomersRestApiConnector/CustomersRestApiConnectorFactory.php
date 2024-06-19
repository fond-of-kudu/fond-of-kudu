<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector;

use FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers\CustomerPasswordWriter;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers\CustomerPasswordWriterInterface;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerRestorePasswordResourceMapper;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerRestorePasswordResourceMapperInterface;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiError;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiErrorInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class CustomersRestApiConnectorFactory extends AbstractFactory
{
    /**
     * @return \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers\CustomerPasswordWriterInterface
     */
    public function createCustomerPasswordWriter(): CustomerPasswordWriterInterface
    {
        return new CustomerPasswordWriter(
            $this->getCustomerPasswordUpdateAtConnectorClient(),
            $this->getResourceBuilder(),
            $this->createCustomerRestorePasswordResourceMapper(),
            $this->createRestApiError(),
        );
    }

    /**
     * @return \FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface
     */
    protected function getCustomerPasswordUpdateAtConnectorClient(): CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface
    {
        return $this->getProvidedDependency(CustomersRestApiConnectorDependencyProvider::CLIENT_CUSTOMER_PASSWORD_UPDATE_AT_CONNECTOR);
    }

    /**
     * @return \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerRestorePasswordResourceMapperInterface
     */
    protected function createCustomerRestorePasswordResourceMapper(): CustomerRestorePasswordResourceMapperInterface
    {
        return new CustomerRestorePasswordResourceMapper();
    }

    /**
     * @return \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiErrorInterface
     */
    protected function createRestApiError(): RestApiErrorInterface
    {
        return new RestApiError();
    }
}
