<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client;

use Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

interface CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function restorePassword(CustomerTransfer $customerTransfer): CustomerResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer
     */
    public function passwordUpdated(CustomerTransfer $customerTransfer): CustomerPasswordUpdatedResponseTransfer;
}
