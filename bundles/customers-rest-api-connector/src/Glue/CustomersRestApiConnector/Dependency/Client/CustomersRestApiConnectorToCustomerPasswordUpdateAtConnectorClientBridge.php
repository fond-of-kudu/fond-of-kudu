<?php

namespace Glue\CustomersRestApiConnector\Dependency\Client;

use FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorClientInterface;

class CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientBridge
{
    /**
     * @var CustomerPasswordUpdatedAtConnectorClientInterface
     */
    protected CustomerPasswordUpdatedAtConnectorClientInterface $client;

    /**
     * @param CustomerPasswordUpdatedAtConnectorClientInterface $client
     */
    public function __construct(CustomerPasswordUpdatedAtConnectorClientInterface $client)
    {
        $this->client = $client;
    }
}
