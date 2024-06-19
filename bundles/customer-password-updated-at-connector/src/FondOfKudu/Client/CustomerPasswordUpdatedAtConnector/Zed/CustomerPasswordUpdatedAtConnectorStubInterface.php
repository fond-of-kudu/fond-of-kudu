<?php

namespace FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Zed;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerPasswordUpdatedAtConnectorStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function restorePassword(CustomerTransfer $customerTransfer): CustomerResponseTransfer;
}
