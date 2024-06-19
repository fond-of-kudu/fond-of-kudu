<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client;

use FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorClientInterface;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

class CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientBridge implements CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface
{
    /**
     * @var \FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorClientInterface
     */
    protected CustomerPasswordUpdatedAtConnectorClientInterface $client;

    /**
     * @param \FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorClientInterface $client
     */
    public function __construct(CustomerPasswordUpdatedAtConnectorClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function restorePassword(CustomerTransfer $customerTransfer): CustomerResponseTransfer
    {
        return $this->client->restorePassword($customerTransfer);
    }
}
