<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer;

use Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerPasswordUpdatedInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer
     */
    public function passwordUpdated(CustomerTransfer $customerTransfer): CustomerPasswordUpdatedResponseTransfer;
}
